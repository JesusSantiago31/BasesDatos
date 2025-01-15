<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrar Producto</title>
    <link rel="stylesheet" href="css/style_borrar.css"> <!-- Enlaza tu archivo de estilos CSS -->
</head>
<body>
    <div class="container">
        <h1>Borrar Producto</h1>

        <?php
        if (isset($_GET['error'])) {
            echo "<p class='error-message'>{$_GET['error']}</p>";
        }
        if (isset($_GET['success'])) {
            echo "<p class='success-message'>{$_GET['success']}</p>";
        }
        ?>

        <!-- Formulario para borrar un producto -->
        <form method="POST" action="borra_producto.php">
            <label for="id_producto">ID del Producto:</label>
            <input type="number" name="id_producto" required><br>

            <button type="submit">Borrar Producto</button>
        </form>

        <button onclick="window.location.href='productos.php'">Volver</button>
    </div>
</body>
</html>
