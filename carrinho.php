<?php
include 'includes/header.php';

if(!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit();
}

// Adicionar item ao carrinho
if(isset($_POST['adicionar'])) {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'] ?? 1;
    
    // Verificar se já está no carrinho
    $stmt = $conn->prepare("SELECT * FROM carrinho_compras WHERE cliente_id = ? AND produto_id = ?");
    $stmt->execute([$_SESSION['cliente_id'], $produto_id]);
    
    if($stmt->rowCount() > 0) {
        // Atualizar quantidade
        $stmt = $conn->prepare("UPDATE carrinho_compras SET quantidade = quantidade + ? WHERE cliente_id = ? AND produto_id = ?");
        $stmt->execute([$quantidade, $_SESSION['cliente_id'], $produto_id]);
    } else {
        // Inserir novo item
        $stmt = $conn->prepare("INSERT INTO carrinho_compras (cliente_id, produto_id, quantidade, data_adicao) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['cliente_id'], $produto_id, $quantidade]);
    }
    
    header("Location: carrinho.php");
    exit();
}

// Remover item do carrinho
if(isset($_GET['remover'])) {
    $stmt = $conn->prepare("DELETE FROM carrinho_compras WHERE carrinho_id = ? AND cliente_id = ?");
    $stmt->execute([$_GET['remover'], $_SESSION['cliente_id']]);
    
    header("Location: carrinho.php");
    exit();
}

// Buscar itens do carrinho
$stmt = $conn->prepare("SELECT c.*, p.nome, p.preco, p.imagem FROM carrinho_compras c 
                       JOIN produtos p ON c.produto_id = p.produto_id 
                       WHERE c.cliente_id = ?");
$stmt->execute([$_SESSION['cliente_id']]);
$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach($itens as $item) {
    $total += $item['preco'] * $item['quantidade'];
}
?>

<div class="container carrinho-container">
    <h1>Seu Carrinho</h1>
    
    <?php if(empty($itens)): ?>
        <p>Seu carrinho está vazio</p>
    <?php else: ?>
        <table class="carrinho-table">
            <!-- Tabela de itens -->
            <?php foreach($itens as $item): ?>
            <tr>
                <td><img src="images/<?= $item['imagem'] ?>" width="50"></td>
                <td><?= $item['nome'] ?></td>
                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                <td><?= $item['quantidade'] ?></td>
                <td>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></td>
                <td><a href="carrinho.php?remover=<?= $item['carrinho_id'] ?>">Remover</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <div class="carrinho-total">
            <strong>Total: R$ <?= number_format($total, 2, ',', '.') ?></strong>
        </div>
        
        <a href="checkout.php" class="btn">Finalizar Compra</a>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>