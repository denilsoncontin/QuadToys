<?php
// remove_from_cart.php
session_start();
include 'includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit();
}

$cart_id = $_GET['id'] ?? null;

if (!$cart_id) {
    echo json_encode(['success' => false, 'message' => 'ID do item não fornecido']);
    exit();
}

try {
    $stmt = $conn->prepare("DELETE FROM carrinho_compras WHERE carrinho_id = ? AND cliente_id = ?");
    $stmt->execute([$cart_id, $_SESSION['cliente_id']]);
    
    echo json_encode(['success' => true]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>