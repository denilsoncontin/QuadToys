<?php
// Iniciar a sessão no início do arquivo, antes de qualquer saída HTML
session_start();

// Incluir configuração da conexão com o banco de dados
require_once 'includes/config.php';

// Se o usuário já estiver logado, redirecionar para a página inicial
if(isset($_SESSION['cliente_id'])) {
    header("Location: index.php");
    exit(); // Importante para interromper a execução do script após redirecionamento
}

// Processar o formulário de login
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM clientes WHERE email = ?");
        $stmt->execute([$email]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($cliente && password_verify($senha, $cliente['senha'])) {
            // Login bem-sucedido
            $_SESSION['cliente_id'] = $cliente['cliente_id'];
            $_SESSION['nome'] = $cliente['nome'];
            
            // Redirecionar para a página inicial
            header("Location: index.php");
            exit(); // Importante para interromper a execução
        } else {
            $erro = "E-mail ou senha incorretos";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao realizar login. Tente novamente mais tarde.";
        // Log do erro para debug
        error_log("Erro de login: " . $e->getMessage());
    }
}

// Agora incluir o header para a página
include 'includes/header.php';
?>

<div class="container auth-container">
    <h1>Login</h1>
    <?php if(isset($erro)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" required class="form-control" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>">
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="senha" required class="form-control">
        </div>
        <button type="submit" class="btn">Entrar</button>
        <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </form>
</div>

<?php include 'includes/footer.php'; ?>