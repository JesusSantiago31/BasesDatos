<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha_registro = date('Y-m-d');
    $numero_compras = 0;

    // Verificar si el correo ya existe
    $sql = "SELECT * FROM clientes WHERE correo = :correo";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['correo' => $correo]);
    $cliente_existente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente_existente) {
        // Redirigir con un mensaje de error si el correo ya existe
        header('Location: agregar_cliente.php?error=El correo ya está registrado');
        exit;
    }

    // Insertar el nuevo cliente si el correo no existe
    $sql = "INSERT INTO clientes (nombre, correo, fecha_registro, numero_compras) VALUES (:nombre, :correo, :fecha_registro, :numero_compras)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nombre' => $nombre,
        'correo' => $correo,
        'fecha_registro' => $fecha_registro,
        'numero_compras' => $numero_compras
    ]);

    header('Location: clientes.php?success=Cliente agregado exitosamente');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="css/style_clientes.css">
</head>
<body>
    <h1>Agregar Cliente</h1>

    <!-- Mostrar mensaje de error si es necesario -->
    <?php if (isset($_GET['error'])): ?>
        <div class="mensaje-error">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        
        <button type="submit">Agregar Cliente</button>
    </form>
    <a href="clientes.php">Regresar</a>
</body>
</html>
