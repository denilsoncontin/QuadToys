<?php
include 'includes/header.php';

// Inicializar variáveis
$nome = $email = $senha = $confirmar_senha = '';
$erro = '';
$sucesso = '';

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter e sanitizar dados do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Validar os dados
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem.";
    } else {
        // Verificar se o e-mail já está cadastrado
        try {
            $stmt = $conn->prepare("SELECT cliente_id FROM clientes WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $erro = "Este e-mail já está cadastrado.";
            } else {
                // Inserir novo cliente
                $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO clientes (nome, email, senha, data_cadastro, ultimo_acesso, status) VALUES (?, ?, ?, NOW(), NOW(), 'ativo')");
                $stmt->execute([$nome, $email, $hash_senha]);
                
                // Obter o ID do cliente recém-cadastrado
                $cliente_id = $conn->lastInsertId();
                
                // Iniciar a sessão
                $_SESSION['cliente_id'] = $cliente_id;
                $_SESSION['nome'] = $nome;
                
                // Redirecionar para a página inicial
                header("Location: index.php");
                exit();
            }
        } catch(PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>

<div class="container auth-container">
    <h1>Cadastre-se</h1>
    
    <?php if(!empty($erro)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    
    <?php if(!empty($sucesso)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Nome Completo</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required class="form-control">
        </div>
        
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="senha" required class="form-control">
            <small class="form-text text-muted">A senha deve ter pelo menos 6 caracteres.</small>
        </div>
        
        <div class="form-group">
            <label>Confirmar Senha</label>
            <input type="password" name="confirmar_senha" required class="form-control">
        </div>
        
        <button type="submit" class="btn">Cadastrar</button>
        <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>