<?php
include 'autenticador_cliente.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (autenticarCliente($email, $password, $pdo)) {
            header('Location: perfil_cliente.php');
            exit();
        } else {
            $login_error = "Credenciales incorrectas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/style_client.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <?php
        if (isset($login_error)) {
            echo "<p class='error-message'>$login_error</p>";
        }
        ?>
        <form method="POST">
        <img src="css/img/form.png" alt="Imagen de Pizza" class="form-image">
            <label for="email">Correo:</label>
            <input type="email" name="email" required><br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="resgistro_cliente.php" target="_blank">Regístrate aquí</a></p>
    </div>
</body>
</html>

