<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha_registro = date('Y-m-d');

    $sql = "INSERT INTO clientes (nombre, correo, fecha_registro) VALUES (:nombre, :correo, :fecha_registro)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([':nombre' => $nombre, ':correo' => $correo, ':fecha_registro' => $fecha_registro]);
        echo "Cliente agregado exitosamente.";
    } catch (PDOException $e) {
        echo "Error al agregar el cliente: " . $e->getMessage();
    }
}
?>
