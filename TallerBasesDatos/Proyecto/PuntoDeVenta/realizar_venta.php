<?php
include 'db.php';

// Función para consultar inventario bajo
function consultarInventarioBajo($pdo, $min_stock) {
    $stmt = $pdo->prepare("CALL ConsultarInventarioBajo(?)");
    $stmt->execute([$min_stock]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['consultar_inventario'])) {
        $min_stock = $_POST['min_stock'];
        $productos_bajo_stock = consultarInventarioBajo($pdo, $min_stock);
        foreach ($productos_bajo_stock as $producto) {
            echo "ID Producto: {$producto['id_producto']}, Nombre: {$producto['nombre_producto']}, Stock: {$producto['stock']}<br>";
        }
    } else {
        // Obtener datos de la venta
        $id_cliente = $_POST['id_cliente'];
        $productos_seleccionados = $_POST['productos'];
        $total = 0;
        $aplicar_descuento = isset($_POST['aplicar_descuento']) ? true : false;
        $puntos_a_descontar = isset($_POST['puntos_a_descontar']) ? (int)$_POST['puntos_a_descontar'] : 0;

        // Iniciar la transacción
        $pdo->beginTransaction();

        try {
            // Calcular el total antes de aplicar el descuento
            foreach ($productos_seleccionados as $producto) {
                $id_producto = $producto['id_producto'];
                $cantidad = $producto['cantidad'];
                $precio_unitario = $producto['precio'];
                $total += $cantidad * $precio_unitario;

                // Verificar si hay suficiente stock para cada producto
                $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id_producto = ?");
                $stmt->execute([$id_producto]);
                $producto_stock = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($producto_stock['stock'] < $cantidad) {
                    throw new Exception("No hay suficiente stock para el producto ID: $id_producto");
                }
            }

            // Consultar los puntos del cliente
            $stmt = $pdo->prepare("SELECT puntos_acumulados FROM tarjeta_puntos WHERE id_cliente = ?");
            $stmt->execute([$id_cliente]);
            $puntos_acumulados = $stmt->fetch(PDO::FETCH_ASSOC)['puntos_acumulados'];

            // Validar los puntos ingresados
            if ($puntos_a_descontar > $puntos_acumulados) {
                throw new Exception("No tienes suficientes puntos para descontar.");
            }

            // Calcular el descuento si se aplica
            if ($aplicar_descuento) {
                $valor_por_punto = 1.0; // Valor de cada punto en dinero
                $descuento_en_dinero = $puntos_a_descontar * $valor_por_punto;

                // Verificar que el descuento no exceda el total de la compra
                if ($descuento_en_dinero > $total) {
                    throw new Exception("El descuento no puede ser mayor al total de la compra.");
                }

                // Aplicar el descuento
                $total_con_descuento = $total - $descuento_en_dinero;
            } else {
                $total_con_descuento = $total;
            }

            // Actualizar los puntos del cliente
            if ($aplicar_descuento) {
                $nuevo_puntos = $puntos_acumulados - $puntos_a_descontar;
                $stmt = $pdo->prepare("UPDATE tarjeta_puntos SET puntos_acumulados = ? WHERE id_cliente = ?");
                $stmt->execute([$nuevo_puntos, $id_cliente]);
            }

            // Insertar la venta
            $stmt = $pdo->prepare("INSERT INTO ventas (id_cliente, fecha_venta, total) VALUES (?, NOW(), ?)");
            $stmt->execute([$id_cliente, $total_con_descuento]);
            $id_venta = $pdo->lastInsertId();

            // Insertar productos de la venta y actualizar el stock
            foreach ($productos_seleccionados as $producto) {
                $id_producto = $producto['id_producto'];
                $cantidad = $producto['cantidad'];
                $subtotal = $cantidad * $producto['precio'];

                // Insertar en la tabla de detalle_ventas
                $stmt = $pdo->prepare("INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)");
                $stmt->execute([$id_venta, $id_producto, $cantidad, $subtotal]);

                // Actualizar el stock del producto
                $stmt = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id_producto = ?");
                $stmt->execute([$cantidad, $id_producto]);
            }

            // Incrementar el número de compras del cliente
            $stmt = $pdo->prepare("UPDATE clientes SET numero_compras = numero_compras + 1 WHERE id_cliente = ?");
            $stmt->execute([$id_cliente]);

            // Incrementar los puntos del cliente por la compra realizada
            $stmt = $pdo->prepare("CALL IncrementarPuntosCliente(?, ?)");
            $stmt->execute([$id_cliente, $total_con_descuento]);

            // Confirmar la transacción
            $pdo->commit();

            header("Location: ventas.php?mensaje=" . urlencode("Venta realizada correctamente y puntos actualizados") . "&tipo_mensaje=success");
            exit;

        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
