<?php
// Datos de la base de datos
$host = 'localhost';
$db = 'sistema_pos';
$user = 'root'; // Reemplaza con tu usuario de la base de datos
$pass = ''; // Reemplaza con tu contraseña de la base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Establece el modo de error de PDO para que lance excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
