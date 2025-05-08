<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Verificar se foi fornecido um ID de categoria
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: categorias.php");
    exit();
}

$categoria_id = $_GET['id'];

// Buscar informações da categoria
try {
    $stmt = $conn->prepare("SELECT * FROM categorias WHERE categoria_id = ?");
    $stmt->execute([$categoria_id]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$categoria) {
        header("Location: categorias.php");
        exit();
    }
} catch (PDOException $e) {
    die("Erro ao buscar categoria: " . $e->getMessage());
}

// Buscar produtos da categoria
try {
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE categoria_id = ? ORDER BY nome");
    $stmt->execute([$categoria_id]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}

// Função auxiliar para definir o caminho da imagem do produto
function get_product_image($produto_id, $produto_nome) {
    // Array associativo com mapeamento de IDs para caminhos de imagens
    $imagens = [
        // Formato: ID_do_produto => caminho_da_imagem
        3 => "images/produtos/spider_man.jpg",
        2 => "images/produtos/pokemon.jpg",
        8 => "images/produtos/magic.jpg",
        9 => "images/produtos/goku.jpg",
        1 => "images/produtos/iron_man.jpg",
        6 => "images/produtos/varinha.jpg",
        4 => "images/produtos/batmovel.jpg",
        11 => "images/produtos/dompedro.jpg",
        10 => "images/produtos/batmancav.jpg",
        5 => "images/produtos/one_piece.jpg",
        7 => "images/produtos/darth_vader.jpg",
        12 => "images/produtos/amazingfantasy.jpg",
        // Adicione mais produtos conforme necessário
    ];
    
    // Verificar se existe um caminho definido para este produto
    if (isset($imagens[$produto_id])) {
        return $imagens[$produto_id];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($categoria['nome']) ?> - QuadToys</title>
    <style>
        .categoria-banner {
            background-color: #f8f9fa;
            padding: 40px 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        .categoria-banner h1 {
            font-size: 2.5em;
            color: #333;
            margin-bottom: 15px;
        }
        .categoria-banner p {
            font-size: 1.1em;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
        }
        .produtos-container {
            padding: 20px 0 60px;
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
            transition: transform 0.3s ease;
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
            overflow: hidden;
        }
        .produto-img img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .produto-info {
            padding: 15px;
        }
        .produto-info h3 {
            margin-top: 0;
            font-size: 1.2em;
            color: #333;
            margin-bottom: 10px;
        }
        .produto-preco {
            font-size: 1.3em;
            color: #e74c3c;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .produto-acoes {
            display: flex;
            justify-content: space-between;
        }
        .btn-detalhes, .btn-carrinho {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-detalhes {
            background-color: #f0f0f0;
            color: #333;
        }
        .btn-carrinho {
            background-color: #e74c3c;
            color: white;
        }
        .btn-detalhes:hover {
            background-color: #e0e0e0;
        }
        .btn-carrinho:hover {
            background-color: #c0392b;
        }
        .sem-produtos {
            text-align: center;
            padding: 40px 0;
            color: #666;
        }
        .sem-produtos h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .sem-produtos p {
            margin-bottom: 30px;
        }
        .sem-produtos a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="categoria-banner">
        <h1><?= htmlspecialchars($categoria['nome']) ?></h1>
        <p><?= htmlspecialchars($categoria['descricao'] ?? 'Explore nossa coleção de ' . $categoria['nome']) ?></p>
    </div>
    
    <div class="produtos-container">
        <?php if (count($produtos) > 0): ?>
            <div class="produtos-grid">
                <?php foreach ($produtos as $produto): 
                    // Aqui você pode personalizar o caminho da imagem para cada produto individualmente
                    // Comentando e descomentando as linhas conforme necessário
                    
                    // Opção 1: Usar a função helper (recomendado para organização)
                    $imagem_src = get_product_image($produto['produto_id'], $produto['nome']);
                    
                    // Opção 2: Definir diretamente aqui (mais fácil para personalização rápida)
                    // Exemplo: Se quiser definir uma imagem específica para um produto específico
                    if ($produto['produto_id'] == 1) {
                        $imagem_src = "images/produtos/produto1.jpg";
                    } 
                    elseif ($produto['produto_id'] == 2) {
                        $imagem_src = "images/produtos/produto2.jpg";
                    }
                    // ... adicione mais condições conforme necessário
                    
                    // Fallback para imagem padrão
                    if (!isset($imagem_src) || empty($imagem_src)) {
                        $imagem_src = "images/placeholder.jpg";
                    }
                ?>
                    <div class="produto-card">
                        <div class="produto-img">
                            <!-- Este é o elemento de imagem que usará o caminho definido acima -->
                            <img src="<?= $imagem_src ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        </div>
                        <div class="produto-info">
                            <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                            <p class="produto-preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                            <div class="produto-acoes">
                                <a href="produto.php?id=<?= $produto['produto_id'] ?>" class="btn-detalhes">Detalhes</a>
                                <form method="post" action="add_to_cart.php" style="display: inline;">
                                    <input type="hidden" name="produto_id" value="<?= $produto['produto_id'] ?>">
                                    <input type="hidden" name="quantidade" value="1">
                                    <button type="submit" class="btn-carrinho">+ Carrinho</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="sem-produtos">
                <h3>Nenhum produto encontrado nesta categoria</h3>
                <p>Estamos trabalhando para adicionar novos produtos em breve!</p>
                <a href="categorias.php">Ver outras categorias</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>