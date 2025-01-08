<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesion</title>
    <link rel="stylesheet" href="css/style_admin.css">
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <form action="autenticador_administrador.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
