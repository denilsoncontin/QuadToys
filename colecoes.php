<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Buscar todas as categorias
try {
    $stmt = $conn->query("SELECT * FROM categorias ORDER BY nome");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar categorias: " . $e->getMessage());
}

// Buscar produtos em destaque para cada categoria
$categoriasComProdutos = [];
foreach ($categorias as $categoria) {
    try {
        $stmt = $conn->prepare("SELECT * FROM produtos WHERE categoria_id = ? AND estoque > 0 ORDER BY RAND() LIMIT 4");
        $stmt->execute([$categoria['categoria_id']]);
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($produtos) > 0) {
            $categoria['produtos'] = $produtos;
            $categoriasComProdutos[] = $categoria;
        }
    } catch (PDOException $e) {
        // Apenas log do erro, continua para a próxima categoria
        error_log("Erro ao buscar produtos da categoria {$categoria['nome']}: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Explorar Coleções - QuadToys</title>
    <style>
        .colecoes-container {
            padding: 30px 0;
        }
        .colecao-section {
            margin-bottom: 50px;
        }
        .colecao-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        .colecao-header h2 {
            margin: 0;
            color: #333;
            font-size: 1.8em;
        }
        .colecao-header a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }
        .produto-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .produto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .produto-img {
            height: 200px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #eee;
        }
        .produto-img img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }
        .produto-info {
            padding: 15px;
        }
        .produto-info h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.1em;
            color: #333;
        }
        .produto-info .preco {
            font-size: 1.2em;
            color: #4CAF50;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .produto-actions {
            display: flex;
            justify-content: space-between;
        }
        .btn-ver, .btn-add {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-ver {
            background-color: #f0f0f0;
            color: #333;
        }
        .btn-add {
            background-color: #4CAF50;
            color: white;
        }
        .btn-ver:hover {
            background-color: #e0e0e0;
        }
        .btn-add:hover {
            background-color: #45a049;
        }
        .banner {
            background-color: #f8f9fa;
            padding: 50px 20px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 8px;
            background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('img/patterns/pattern1.jpg');
            background-size: cover;
        }
        .banner h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #333;
        }
        .banner p {
            font-size: 1.2em;
            max-width: 800px;
            margin: 0 auto 20px;
            line-height: 1.6;
            color: #666;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="banner">
        <h1>Explore Nossas Coleções</h1>
        <p>Descubra um mundo de quadrinhos raros, action figures exclusivos e itens de colecionador que farão a alegria de qualquer fã. Nossa seleção é atualizada regularmente para trazer sempre as peças mais desejadas.</p>
    </div>

    <div class="colecoes-container">
        <?php foreach ($categoriasComProdutos as $categoria): ?>
            <div class="colecao-section">
                <div class="colecao-header">
                    <h2><?= htmlspecialchars($categoria['nome']) ?></h2>
                    <a href="produtos_por_categoria.php?id=<?= $categoria['categoria_id'] ?>">Ver todos →</a>
                </div>
                
                <div class="produtos-grid">
                    <?php foreach ($categoria['produtos'] as $produto): ?>
                        <div class="produto-card" data-id="<?= $produto['produto_id'] ?>" data-name="<?= htmlspecialchars($produto['nome']) ?>" data-price="<?= $produto['preco'] ?>">
                            <div class="produto-img">
                                <!-- Adicione imagem do produto se disponível -->
                                <img src="img/produtos/placeholder.jpg" alt="<?= htmlspecialchars($produto['nome']) ?>">
                            </div>
                            <div class="produto-info">
                                <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                                <p class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                                <div class="produto-actions">
                                    <a href="produto.php?id=<?= $produto['produto_id'] ?>" class="btn-ver">Ver Detalhes</a>
                                    <button class="btn-add add-to-cart">+ Carrinho</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>