<?php
// Iniciar buffer de saída
ob_start();

session_start();
include 'includes/config.php';

// Verificar se é uma requisição AJAX
$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Para requisições AJAX
if ($is_ajax) {
    // Limpar todo o buffer de saída
    ob_end_clean();
    
    // Definir cabeçalho de resposta JSON
    header('Content-Type: application/json');
    
    // Verificar se usuário está logado
    if(!isset($_SESSION['cliente_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
        exit();
    }
    
    // Receber e validar dados JSON
    $json_str = file_get_contents('php://input');
    $data = json_decode($json_str, true);
    
    if (!$data || !isset($data['produto_id']) || !is_numeric($data['produto_id'])) {
        echo json_encode(['success' => false, 'message' => 'ID de produto inválido']);
        exit();
    }
    
    $produto_id = (int)$data['produto_id'];
    $quantidade = isset($data['quantidade']) && is_numeric($data['quantidade']) ? (int)$data['quantidade'] : 1;
    
    // Verificar se a quantidade é válida
    if ($quantidade < 1) {
        echo json_encode(['success' => false, 'message' => 'Quantidade inválida']);
        exit();
    }
    
    try {
        // Verificar se o produto existe e tem estoque suficiente
        $stmt = $conn->prepare("SELECT produto_id, nome, preco, estoque FROM produtos WHERE produto_id = ?");
        $stmt->execute([$produto_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$produto) {
            echo json_encode(['success' => false, 'message' => 'Produto não encontrado']);
            exit();
        }
        
        // Verificar estoque
        if ($produto['estoque'] < $quantidade) {
            echo json_encode(['success' => false, 'message' => 'Estoque insuficiente']);
            exit();
        }
        
        // Verificar se já está no carrinho
        $stmt = $conn->prepare("SELECT * FROM carrinho_compras WHERE cliente_id = ? AND produto_id = ?");
        $stmt->execute([$_SESSION['cliente_id'], $produto_id]);
        
        if($stmt->rowCount() > 0) {
            // Buscar quantidade atual
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            $nova_quantidade = $item['quantidade'] + $quantidade;
            
            // Verificar se a nova quantidade não ultrapassa o estoque
            if ($nova_quantidade > $produto['estoque']) {
                $nova_quantidade = $produto['estoque'];
            }
            
            // Atualizar quantidade
            $stmt = $conn->prepare("UPDATE carrinho_compras SET quantidade = ? WHERE cliente_id = ? AND produto_id = ?");
            $stmt->execute([$nova_quantidade, $_SESSION['cliente_id'], $produto_id]);
        } else {
            // Inserir novo item
            $stmt = $conn->prepare("INSERT INTO carrinho_compras (cliente_id, produto_id, quantidade, data_adicao) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$_SESSION['cliente_id'], $produto_id, $quantidade]);
        }
        
        echo json_encode(['success' => true]);
        exit();
    } catch(PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
        exit();
    } catch(Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
        exit();
    }
} 
// Para requisições de formulário tradicional
else {
    // Limpar o buffer para requisições tradicionais também
    ob_end_clean();
    
    // Verificar se usuário está logado
    if(!isset($_SESSION['cliente_id'])) {
        // Redirecionar para a página de login
        header("Location: login.php?redirect=" . urlencode($_SERVER['HTTP_REFERER'] ?? 'index.php'));
        exit();
    }
    
    // Receber e validar dados do formulário
    $produto_id = isset($_POST['produto_id']) && is_numeric($_POST['produto_id']) ? (int)$_POST['produto_id'] : 0;
    $quantidade = isset($_POST['quantidade']) && is_numeric($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;
    $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : ($_SERVER['HTTP_REFERER'] ?? 'index.php');
    
    // Validar produto_id e quantidade
    if ($produto_id <= 0 || $quantidade < 1) {
        header("Location: $redirect?erro=dados_invalidos");
        exit();
    }
    
    try {
        // Verificar se o produto existe e tem estoque suficiente
        $stmt = $conn->prepare("SELECT produto_id, nome, preco, estoque FROM produtos WHERE produto_id = ?");
        $stmt->execute([$produto_id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$produto) {
            header("Location: $redirect?erro=produto_nao_encontrado");
            exit();
        }
        
        // Verificar estoque
        if ($produto['estoque'] < $quantidade) {
            header("Location: $redirect?erro=estoque_insuficiente&disponivel=" . $produto['estoque']);
            exit();
        }
        
        // Verificar se já está no carrinho
        $stmt = $conn->prepare("SELECT * FROM carrinho_compras WHERE cliente_id = ? AND produto_id = ?");
        $stmt->execute([$_SESSION['cliente_id'], $produto_id]);
        
        if($stmt->rowCount() > 0) {
            // Buscar quantidade atual
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            $nova_quantidade = $item['quantidade'] + $quantidade;
            
            // Verificar se a nova quantidade não ultrapassa o estoque
            if ($nova_quantidade > $produto['estoque']) {
                $nova_quantidade = $produto['estoque'];
            }
            
            // Atualizar quantidade
            $stmt = $conn->prepare("UPDATE carrinho_compras SET quantidade = ? WHERE cliente_id = ? AND produto_id = ?");
            $stmt->execute([$nova_quantidade, $_SESSION['cliente_id'], $produto_id]);
        } else {
            // Inserir novo item
            $stmt = $conn->prepare("INSERT INTO carrinho_compras (cliente_id, produto_id, quantidade, data_adicao) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$_SESSION['cliente_id'], $produto_id, $quantidade]);
        }
        
        // Redirecionar de volta com mensagem de sucesso
        header("Location: $redirect?status=adicionado");
        exit();
    } catch(PDOException $e) {
        // Log do erro
        error_log("Erro ao adicionar ao carrinho: " . $e->getMessage());
        // Redirecionar com mensagem de erro
        header("Location: $redirect?erro=erro_sistema");
        exit();
    }
}
?>