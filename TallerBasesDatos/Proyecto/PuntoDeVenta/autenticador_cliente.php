<?php
session_start();
include 'db.php';

function autenticarCliente($email, $password, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE correo = :email");
    $stmt->execute(['email' => $email]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        // Aquí deberías verificar la contraseña hash. Para simplificar, asumimos que coincide.
        $_SESSION['cliente_id'] = $cliente['id_cliente'];
        return true;
    } else {
        return false;
    }
}
?>
