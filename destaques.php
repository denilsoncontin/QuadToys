<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Buscar produtos em destaque
try {
    // Aqui estamos selecionando produtos aleatórios, mas você pode adicionar uma coluna 'destaque' na tabela
    $stmt = $conn->query("SELECT p.*, c.nome as categoria_nome 
                         FROM produtos p 
                         JOIN categorias c ON p.categoria_id = c.categoria_id 
                         WHERE p.estoque > 0 
                         ORDER BY RAND() LIMIT 12");
    $destaques = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos em destaque: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Produtos em Destaque - QuadToys</title>
    <style>
        .destaques-container {
            padding: 30px 0;
        }
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .page-header h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
        }
        .page-header p {
            color: #666;
            font-size: 1.1em;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }
        .produtos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
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
        .produto-categoria {
            color: #777;
            font-size: 0.9em;
            margin-bottom: 10px;
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
        .destaque-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ff9800;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="destaques-container">
        <div class="page-header">
            <h1>Produtos em Destaque</h1>
            <p>Confira nossa seleção de produtos mais populares e exclusivos. Atualizamos esta lista regularmente com base nas tendências e preferências dos colecionadores.</p>
        </div>
        
        <div class="produtos-grid">
            <?php foreach ($destaques as $produto): ?>
                <div class="produto-card" data-id="<?= $produto['produto_id'] ?>" data-name="<?= htmlspecialchars($produto['nome']) ?>" data-price="<?= $produto['preco'] ?>">
                    <div class="produto-img">
                        <span class="destaque-badge">Destaque</span>
                        <!-- Adicione imagem do produto se disponível -->
                        <img src="img/produtos/placeholder.jpg" alt="<?= htmlspecialchars($produto['nome']) ?>">
                    </div>
                    <div class="produto-info">
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <p class="produto-categoria">Categoria: <?= htmlspecialchars($produto['categoria_nome']) ?></p>
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
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>