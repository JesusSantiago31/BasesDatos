<?php
include 'db.php';

// Obtener los clientes para el formulario
$stmt = $pdo->query("SELECT id_cliente, nombre FROM clientes");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener los productos para agregar a la venta
$stmt = $pdo->query("SELECT id_producto, nombre_producto, precio FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $productos_seleccionados = $_POST['productos'];
    $puntos_a_descontar = isset($_POST['puntos_a_descontar']) ? (int)$_POST['puntos_a_descontar'] : 0;

    $detalles = [];
    $total = 0;

    foreach ($productos_seleccionados as $producto) {
        $detalles[] = [
            'id_producto' => $producto['id_producto'],
            'cantidad' => $producto['cantidad'],
            'precio' => $producto['precio']
        ];
        $total += $producto['cantidad'] * $producto['precio'];
    }

    try {
        // Consultar los puntos acumulados del cliente
        $stmt = $pdo->prepare("SELECT puntos_acumulados FROM tarjeta_puntos WHERE id_cliente = ?");
        $stmt->execute([$id_cliente]);
        $puntos_acumulados = $stmt->fetchColumn();

        // Validar puntos disponibles y aplicar descuento
        $valor_por_punto = 0.1; // Cada punto equivale a 0.10 unidades monetarias
        $descuento = min($puntos_a_descontar * $valor_por_punto, $total);
        $total_con_descuento = $total - $descuento;

        if ($puntos_a_descontar > $puntos_acumulados) {
            throw new Exception("No tienes suficientes puntos para realizar este descuento.");
        }

        // Actualizar puntos del cliente
        $nuevo_total_puntos = $puntos_acumulados - $puntos_a_descontar;
        $stmt = $pdo->prepare("UPDATE tarjeta_puntos SET puntos_acumulados = ? WHERE id_cliente = ?");
        $stmt->execute([$nuevo_total_puntos, $id_cliente]);

        // Registrar la venta
        $json_detalles = json_encode($detalles);
        $stmt = $pdo->prepare("CALL RegistrarVentaCompleta(?, NOW(), ?, ?, @nueva_venta_id)");
        $stmt->execute([$id_cliente, $total_con_descuento, $json_detalles]);

        // Obtener el ID de la nueva venta
        $stmt = $pdo->query("SELECT @nueva_venta_id");
        $nueva_venta_id = $stmt->fetchColumn();

        header("Location: ventas.php?success=Venta realizada correctamente&venta_id=$nueva_venta_id");
        exit;
    } catch (Exception $e) {
        echo "Error al realizar la venta: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Venta</title>
    <link rel="stylesheet" href="css/style_ventas.css">
</head>
<body>
    <div class="container">
        <h1>Realizar Venta</h1>

        <form method="POST" action="">
            <label for="id_cliente">Cliente:</label>
            <select name="id_cliente" required>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id_cliente']; ?>"><?php echo $cliente['nombre']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="productos">Productos:</label>
            <table id="tabla_productos">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="producto">
                        <td>
                            <select name="productos[0][id_producto]" onchange="actualizarPrecio(this)" required>
                                <?php foreach ($productos as $producto): ?>
                                    <option value="<?php echo $producto['id_producto']; ?>" data-precio="<?php echo $producto['precio']; ?>">
                                        <?php echo $producto['nombre_producto']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="productos[0][cantidad]" value="1" min="1" onchange="actualizarPrecio(this.closest('tr').querySelector('select'))"></td>
                        <td><input type="text" name="productos[0][precio]" value="" readonly></td>
                        <td><input type="text" name="productos[0][subtotal]" value="0" readonly></td>
                        <td><button type="button" onclick="eliminarProducto(this)">Eliminar</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" onclick="agregarProducto()">Agregar Producto</button><br>

            <label for="puntos_a_descontar">Puntos a Descontar:</label>
            <input type="number" name="puntos_a_descontar" min="0"><br>

            <button type="submit">Finalizar Venta</button>
            <button type="reset">Cancelar</button>
        </form>
        <a href="ventas.php"><button>Volver al Historial de Ventas</button></a>
    </div>

    <script>
        function agregarProducto() {
            var fila = document.querySelector('.producto').cloneNode(true);
            var tabla = document.querySelector('#tabla_productos tbody');
            var numProductos = tabla.querySelectorAll('tr').length;
            fila.querySelector('select').name = 'productos[' + numProductos + '][id_producto]';
            fila.querySelector('input[name="productos[0][cantidad]"]').name = 'productos[' + numProductos + '][cantidad]';
            fila.querySelector('input[name="productos[0][precio]"]').name = 'productos[' + numProductos + '][precio]';
            fila.querySelector('input[name="productos[0][subtotal]"]').name = 'productos[' + numProductos + '][subtotal]';
            tabla.appendChild(fila);
        }

        function eliminarProducto(boton) {
            boton.closest('tr').remove();
        }

        function actualizarPrecio(selectElement) {
            var precio = selectElement.options[selectElement.selectedIndex].getAttribute('data-precio');
            var cantidadInput = selectElement.closest('tr').querySelector('input[name*="[cantidad]"]');
            var precioInput = selectElement.closest('tr').querySelector('input[name*="[precio]"]');
            var subtotalInput = selectElement.closest('tr').querySelector('input[name*="[subtotal]"]');

            precioInput.value = precio;
            subtotalInput.value = (precio * cantidadInput.value).toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var productos = document.querySelectorAll('.producto select');
            productos.forEach(function(select) {
                actualizarPrecio(select);
            });
        });
    </script>
</body>
</html>
