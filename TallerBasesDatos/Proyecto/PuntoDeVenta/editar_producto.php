<?php
include 'db.php'; // Conexión a la base de datos

// Verificar si se ha enviado el ID del producto
if (!isset($_GET['id'])) {
    echo "ID de producto no especificado.";
    exit;
}

// Obtener el ID del producto
$id = $_GET['id'];

// Consultar los datos del producto
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id_producto = ?");
$stmt->execute([$id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el producto existe
if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

// Manejar la actualización del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_producto'];
    $categoria = $_POST['categoria_producto'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $producto['imagen']; // Mantener la imagen actual por defecto

    // Manejar la subida de una nueva imagen
    if (!empty($_FILES['imagen']['name'])) {
        // Verificar que el archivo es una imagen válida
        $check = getimagesize($_FILES['imagen']['tmp_name']);
        if ($check === false) {
            echo "El archivo no es una imagen válida.";
            exit;
        }

        // Generar un nombre único para la imagen
        $imagen = 'images/' . uniqid() . '_' . basename($_FILES['imagen']['name']);
        
        // Mover el archivo a la carpeta uploads
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen)) {
            echo "Error al subir la imagen.";
            exit;
        }
    }

    // Actualizar los datos del producto
    $stmt = $pdo->prepare("UPDATE productos SET nombre_producto = ?, categoria_producto = ?, precio = ?, stock = ?, imagen = ? WHERE id_producto = ?");
    $stmt->execute([$nombre, $categoria, $precio, $stock, $imagen, $id]);

    header("Location: ver_productos.php?success=Producto actualizado correctamente");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="css/style_productos.css">
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>

        <form method="POST" action="editar_producto.php?id=<?php echo htmlspecialchars($id); ?>" enctype="multipart/form-data">
            <label for="nombre_producto">Nombre del Producto:</label>
            <input type="text" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required><br>

            <label for="categoria_producto">Categoría:</label>
            <input type="text" name="categoria_producto" value="<?php echo htmlspecialchars($producto['categoria_producto']); ?>"><br>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required><br>

            <label for="stock">Stock:</label>
            <input type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required><br>

            <label for="imagen">Imagen del Producto:</label>
            <input type="file" name="imagen" accept="image/*"><br>
            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen actual" style="width: 100px; height: auto;"><br>

            <button type="submit">Actualizar Producto</button>
        </form>

        <button onclick="window.location.href='ver_productos.php'">Volver a la Lista de Productos</button>
    </div>
</body>
</html>
