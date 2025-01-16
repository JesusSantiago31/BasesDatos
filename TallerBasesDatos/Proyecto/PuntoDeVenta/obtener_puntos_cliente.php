<?php
include 'db.php';

if (isset($_GET['id_cliente'])) {
    $id_cliente = $_GET['id_cliente'];
    $stmt = $pdo->prepare("SELECT puntos_acumulados FROM tarjeta_puntos WHERE id_cliente = ?");
    $stmt->execute([$id_cliente]);
    $puntos_acumulados = $stmt->fetchColumn();

    echo json_encode(['puntos_acumulados' => $puntos_acumulados]);
} else {
    echo json_encode(['error' => 'Cliente no especificado.']);
}
?>
