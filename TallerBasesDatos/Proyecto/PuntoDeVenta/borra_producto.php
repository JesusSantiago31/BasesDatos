<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Verificar si el producto existe
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id_producto = :id");
    $stmt->execute(['id' => $id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto) {
        // Verificar si el producto ha sido vendido
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM detalle_ventas WHERE id_producto = :id");
        $stmt->execute(['id' => $id_producto]);
        $producto_vendido = $stmt->fetchColumn();

        if ($producto_vendido > 0) {
            // Si el producto ha sido vendido, no se elimina de la base de datos
            // Solo se elimina de la interfaz (esto dependerá de cómo manejes la interfaz en HTML/JS)
            header('Location: borrar_productos.php?error=El producto ha sido vendido y no puede eliminarse de la base de datos');
            exit();
        } else {
            // Eliminar el producto de la base de datos si no ha sido vendido
            $stmt = $pdo->prepare("DELETE FROM productos WHERE id_producto = :id");
            $stmt->execute(['id' => $id_producto]);

            // Redirigir con mensaje de éxito
            header('Location: borrar_productos.php?success=Producto eliminado con éxito');
            exit();
        }
    } else {
        // Redirigir con mensaje de error si el producto no existe
        header('Location: borrar_productos.php?error=Producto no encontrado');
        exit();
    }
} else {
    // Redirigir si no se ha enviado el ID del producto
    header('Location: borrar_productos.php?error=Por favor ingresa un ID válido');
    exit();
}
?>
