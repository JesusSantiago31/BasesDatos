<?php
require 'db.php';

// Manejo de búsqueda
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$sql = "SELECT * FROM clientes";
if ($busqueda) {
    $sql .= " WHERE nombre LIKE :busqueda";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['busqueda' => "%$busqueda%"]);
} else {
    $stmt = $pdo->query($sql);
}
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="css/style_clientes.css">
</head>
<body>
    <h1>Clientes</h1>
    <a href="dasboard.php">Regresar</a>
    <a href="agregar_cliente.php" class="btn-agregar">Agregar Cliente</a> <!-- Botón para agregar cliente -->

    <!-- Mostrar mensaje de éxito si es necesario -->
    <?php if (isset($_GET['success'])): ?>
        <div class="mensaje-exito">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Buscador de Clientes -->
    <form method="GET" action="">
        <input type="text" name="busqueda" placeholder="Buscar por nombre" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit">Buscar</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Fecha de Registro</th>
            <th>Número de Compras</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?php echo htmlspecialchars($cliente['id_cliente']); ?></td>
            <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
            <td><?php echo htmlspecialchars($cliente['correo']); ?></td>
            <td><?php echo htmlspecialchars($cliente['fecha_registro']); ?></td>
            <td><?php echo htmlspecialchars($cliente['numero_compras']); ?></td>
            <td>
                <form method="POST" action="borrar_cliente.php" style="display:inline;">
                    <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
                    <button type="submit" onclick="return confirm('¿Estás seguro de que deseas borrar este cliente?');">Borrar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
