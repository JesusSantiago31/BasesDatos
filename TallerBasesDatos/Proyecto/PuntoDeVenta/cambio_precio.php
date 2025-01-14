<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Precio del Producto</title>
    <link rel="stylesheet" href="css/style_productos.css">
</head>
<body>
    <div class="container">
        <h1>Actualizar Precio del Producto</h1>

        <?php
        if (isset($_GET['error'])) {
            echo "<p class='error-message'>{$_GET['error']}</p>";
        }
        if (isset($_GET['success'])) {
            echo "<p class='success-message'>{$_GET['success']}</p>";
        }
        ?>

        <form method="POST" action="actualizacion_precio.php">
            <label for="id_producto">Producto:</label>
            <select name="id_producto" required>
                <?php
                include 'db.php';
                $stmt = $pdo->query("SELECT id_producto, nombre_producto FROM productos");
                $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($productos as $producto) {
                    echo "<option value='{$producto['id_producto']}'>{$producto['nombre_producto']}</option>";
                }
                ?>
            </select><br>

            <label for="precio">Nuevo Precio:</label>
            <input type="number" step="0.01" name="precio" required><br>

            <button type="submit">Actualizar Precio</button>
        </form>

        <button onclick="window.location.href='ver_productos.php'">Ver Todos los Productos</button>
        <button onclick="window.location.href='productos.php'">Volver</button>
    </div>
</body>
</html>
