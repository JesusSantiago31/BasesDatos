<?php
include 'db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre_producto'], $_POST['precio'], $_POST['stock'])) {
        $nombre_producto = $_POST['nombre_producto'];
        $categoria_producto = isset($_POST['categoria_producto']) ? $_POST['categoria_producto'] : null;
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];

        // Verificar que el precio sea positivo y el stock no sea negativo
        if ($precio <= 0 || $stock < 0) {
            header('Location: agregar_producto.php?error=El precio y el stock deben ser valores positivos.');
            exit();
        }

        // Manejo de la imagen
        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen_tmp = $_FILES['imagen']['tmp_name'];
            $imagen_nombre = $_FILES['imagen']['name'];
            $imagen_extension = strtolower(pathinfo($imagen_nombre, PATHINFO_EXTENSION));
            $imagen_destino = 'images/' . uniqid() . '.' . $imagen_extension;

            // Verificar si el archivo es una imagen
            $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imagen_extension, $valid_extensions)) {
                move_uploaded_file($imagen_tmp, $imagen_destino);
                $imagen = $imagen_destino;
            } else {
                header('Location: productos.php?error=El archivo no es una imagen válida.');
                exit();
            }
        }

        // Preparar la consulta para insertar el producto
        $stmt = $pdo->prepare("INSERT INTO productos (nombre_producto, categoria_producto, precio, stock, imagen) 
                               VALUES (:nombre_producto, :categoria_producto, :precio, :stock, :imagen)");

        // Ejecutar la consulta
        try {
            $stmt->execute([
                'nombre_producto' => $nombre_producto,
                'categoria_producto' => $categoria_producto,
                'precio' => $precio,
                'stock' => $stock,
                'imagen' => $imagen
            ]);
            header('Location: productos.php?success=Producto agregado exitosamente.');
        } catch (PDOException $e) {
            header('Location: productos.php?error=Error al agregar el producto.');
        }
    } else {
        header('Location: productos.php?error=Todos los campos son requeridos.');
    }
}
?>
