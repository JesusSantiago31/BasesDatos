<?php
include 'db.php'; // Conexión a la base de datos

// Consultar todos los productos y su stock disponible usando la función
$stmt = $pdo->prepare("
    SELECT p.*, ObtenerStockDisponible(p.id_producto) AS stock_disponible
    FROM productos p
");
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="css/style_productos.css"> <!-- Enlaza tu archivo de estilos CSS -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .container {
            margin: 20px auto;
            width: 80%;
        }
        .edit-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Productos</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['nombre_producto'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($producto['categoria_producto'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($producto['precio'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($producto['stock'] ?? ''); ?></td>
                        <td>
                            <?php if (!empty($producto['imagen'])): ?>
                                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($producto['nombre_producto'] ?? ''); ?>" style="width: 100px; height: auto;">
                            <?php else: ?>
                                No disponible
                            <?php endif; ?>
                        </td>
                        <td>
    <?php 
    if (!empty($producto['id_producto'])): ?>
        <a class="edit-button" href="editar_producto.php?id=<?php echo htmlspecialchars($producto['id_producto']); ?>">Editar</a>
    <?php else: ?>
        ID no disponible
    <?php endif; ?>
</td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button onclick="window.location.href='productos.php'">Agregar Producto</button>
        <button onclick="window.location.href='productos.php'">Volver al inicio</button>
    </div>
</body>
</html>
