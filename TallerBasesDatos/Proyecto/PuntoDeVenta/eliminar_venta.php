<?php
include 'db.php';

// Verificar si se pasa un ID de venta
if (!isset($_GET['id'])) {
    echo "ID de venta no especificado.";
    exit;
}

// Eliminar la venta
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM ventas WHERE id_venta = ?");
$stmt->execute([$id]);

header("Location: ventas.php?success=Venta eliminada correctamente");
exit;
?>
