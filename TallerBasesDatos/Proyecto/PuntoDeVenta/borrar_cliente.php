<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];

    // Borrar el cliente de la base de datos
    $stmt = $pdo->prepare("DELETE FROM clientes WHERE id_cliente = :id_cliente");
    $stmt->execute(['id_cliente' => $id_cliente]);

    // Redirigir con mensaje de éxito
    header('Location: clientes.php?success=Cliente eliminado con éxito');
    exit();
}
?>
