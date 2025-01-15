<?php
session_start(); // Asegúrate de que la sesión esté iniciada
include 'db.php'; // Incluir archivo de conexión a la base de datos

// Verificar si hay productos en el carrito
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    // Iniciar la transacción
    $pdo->beginTransaction();

    try {
        $total = 0; // Inicializar total de la compra

        // Procesar cada producto del carrito
        foreach ($_SESSION['carrito'] as $producto) {
            $id_producto = $producto['id_producto'];
            $cantidad_comprada = $producto['cantidad'];
            $precio_unitario = $producto['precio'];
            $subtotal = $cantidad_comprada * $precio_unitario;
            $total += $subtotal;

            // Verificar si hay suficiente stock
            $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id_producto = ?");
            $stmt->execute([$id_producto]);
            $producto_db = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto_db && $producto_db['stock'] >= $cantidad_comprada) {
                // Actualizar el stock
                $nuevo_stock = $producto_db['stock'] - $cantidad_comprada;
                $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id_producto = ?");
                $stmt->execute([$nuevo_stock, $id_producto]);
            } else {
                // Si no hay suficiente stock, lanzar una excepción
                throw new Exception("No hay suficiente stock para el producto: " . $producto['nombre_producto']);
            }
        }

        // Registrar la venta (si deseas hacerlo)
        $stmt = $pdo->prepare("INSERT INTO ventas (total, fecha_venta) VALUES (?, NOW())");
        $stmt->execute([$total]);
        $id_venta = $pdo->lastInsertId();

        // Confirmar la transacción
        $pdo->commit();

        // Limpiar el carrito después de realizar la compra
        unset($_SESSION['carrito']);

        // Redirigir a una página de éxito
        header("Location: carrito.php?compra=exitosa");
        exit;

    } catch (Exception $e) {
        // Si ocurre un error, revertir la transacción
        $pdo->rollBack();
        echo "Error al procesar la compra: " . $e->getMessage();
    }
} else {
    echo "El carrito está vacío.";
}
?>
