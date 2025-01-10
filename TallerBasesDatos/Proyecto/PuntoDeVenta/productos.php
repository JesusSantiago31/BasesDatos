<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="css/style_productos.css"> <!-- Enlaza tu archivo de estilos CSS -->
</head>
<body>
    <div class="container">
        <h1>Agregar Producto</h1>

        <?php
        // Mostrar los mensajes de error o éxito dentro del formulario
        if (isset($_GET['error'])) {
            echo "<p class='error-message'>{$_GET['error']}</p>";
        }
        if (isset($_GET['success'])) {
            echo "<p class='success-message'>{$_GET['success']}</p>";
        }
        ?>

        <!-- Formulario para agregar un nuevo producto -->
        <form method="POST" action="insertar_producto.php" enctype="multipart/form-data">
            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" name="nombre_producto" required><br>

            <label for="categoria_producto">Categoría:</label>
            <input type="text" name="categoria_producto"><br>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio"  required min="1"><br>

            <label for="stock">Stock:</label>
            <input type="number" name="stock" required min="1"><br>

            <label for="imagen">Imagen del Producto:</label>
            <input type="file" name="imagen" accept="image/*"><br>

            <button type="submit">Agregar Producto</button>
        </form>

        <!-- Botón para redirigir a la página de ver todos los productos -->
        <button onclick="window.location.href='ver_productos.php'">Ver Todos los Productos</button>

        <!-- Botón para redirigir a la página de actualización de stock -->
        <button onclick="window.location.href='actualizar_productos.php'">Actualizar Stock</button>
        <button onclick="window.location.href='cambio_precio.php'">Actualizar Precio</button>

        <!-- Botón para redirigir a la página de borrar producto -->
        <button onclick="window.location.href='borrar_productos.php'">Borrar Producto</button>

        <button onclick="window.location.href='dasboard.php'">Volver</button>
    </div>
</body>
</html>

