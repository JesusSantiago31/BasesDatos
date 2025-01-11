<?php
include 'db.php'; // Conexión a la base de datos

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_producto'], $_POST['stock'])) {
        $id_producto = $_POST['id_producto'];
        $stock = $_POST['stock'];

        // Verificar que el stock no sea negativo
        if ($stock < 0) {
            $error = "El stock no puede ser negativo.";
        } else {
            // Verificar si el producto existe
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM productos WHERE id_producto = :id_producto");
            $checkStmt->execute(['id_producto' => $id_producto]);
            $exists = $checkStmt->fetchColumn();

            if ($exists) {
                // Preparar la consulta para actualizar el stock
                $stmt = $pdo->prepare("UPDATE productos SET stock = :stock WHERE id_producto = :id_producto");

                // Ejecutar la consulta
                try {
                    $stmt->execute(['stock' => $stock, 'id_producto' => $id_producto]);
                    $success = "Stock actualizado exitosamente.";
                } catch (PDOException $e) {
                    $error = "Error al actualizar el stock.";
                }
            } else {
                $error = "El producto no existe.";
            }
        }
    } else {
        $error = "Todos los campos son requeridos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Stock</title>
    <link rel="stylesheet" href="css/style_stock.css"> <!-- Enlaza tu archivo de estilos CSS -->
</head>
<body>
    
        <div class="container">
        <h1>Actualizar Stock de un Producto</h1>
        
        <?php if ($error): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <!-- Formulario para actualizar el stock de un producto -->
        <form method="POST" action="">
            <label for="id_producto">ID del Producto:</label>
            <input type="number" name="id_producto" required><br>

            <label for="stock">Nuevo Stock:</label>
            <input type="number" name="stock" required><br>

            <button type="submit">Actualizar Stock</button>
        </form>

        <button onclick="window.location.href='productos.php'">Volver</button>
    </div>
</body>
</html>
