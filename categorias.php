<?php
require_once 'includes/config.php';
include 'includes/header.php';

try {
    $stmt = $conn->query("SELECT * FROM categorias ORDER BY nome");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar categorias: " . $e->getMessage());
}
?>
<a href="index.php" style="
    display: inline-block;
    margin: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
">← Voltar para a Página Inicial</a>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Categorias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .categoria-lista {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .categoria-card {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        .categoria-card:hover {
            transform: scale(1.03);
        }
        .categoria-card a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 1.2em;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Categorias</h1>

<div class="categoria-lista">
    <?php foreach ($categorias as $cat): ?>
        <div class="categoria-card">
            <a href="produtos_por_categoria.php?id=<?= $cat['categoria_id'] ?>">
                <?= htmlspecialchars($cat['nome']) ?>
            </a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
