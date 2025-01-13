<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password']; // En un entorno real, debes hash la contraseña.

        // Verificar si el correo ya está registrado
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE correo = :email");
        $stmt->execute(['email' => $email]);
        $existing_cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_cliente) {
            $register_error = "El correo ya está registrado.";
        } else {
            // Insertar el nuevo cliente en la base de datos
            $stmt = $pdo->prepare("INSERT INTO clientes (nombre, correo, fecha_registro) VALUES (:nombre, :email, CURDATE())");
            $stmt->execute(['nombre' => $nombre, 'email' => $email]);
            $register_success = "Registro exitoso. Por favor, inicia sesión.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="css/style_resgistro.css">
</head>
<body>
    <div class="container">
        <h1>Registrar</h1>
        <?php
        if (isset($register_error)) {
            echo "<p class='error-message'>$register_error</p>";
        }
        if (isset($register_success)) {
            echo "<p class='success-message'>$register_success</p>";
        }
        ?>
        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required><br>
            <label for="email">Correo:</label>
            <input type="email" name="email" required><br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Registrar</button>
        </form>
        <button type="button" onclick="window.location.href='login_cliente.php'">Regresar</button>
    </div>
</body>
</html>
