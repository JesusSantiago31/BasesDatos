<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_administrador.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informacion de Punto de venta</title>
    <link rel="stylesheet" href="css/style_informacion.css">
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
    <nav>
        <a href="clientes.php">Clientes</a>
        <a href="productos.php">Productos</a>
        <a href="ventas.php">Ventas</a>
        <a href="puntos.php">Puntos</a>
        <a href="logout.php">Cerrar sesión</a>
    </nav>
</body>
</html>
