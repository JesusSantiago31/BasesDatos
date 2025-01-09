<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificación básica (esto debería hacerse con una base de datos)
    if ($username == 'Jocelin' && $password == '121121') {
        $_SESSION['username'] = $username;
        header("Location: dasboard.php");
    } elseif ($username == 'Jesus' && $password == '311204') {
        $_SESSION['username'] = $username;
        header("Location: dasboard.php");
    } else {
        echo "<p>Usuario o contraseña incorrectos. <a href='login_administrador.php'>Intenta de nuevo</a></p>";
    }
}
?>
