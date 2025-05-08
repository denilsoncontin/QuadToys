<?php
// get_cart.php
session_start();
include 'includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT c.*, p.nome, p.preco FROM carrinho_compras c 
                           JOIN produtos p ON c.produto_id = p.produto_id 
                           WHERE c.cliente_id = ?");
    $stmt->execute([$_SESSION['cliente_id']]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'items' => $items]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>