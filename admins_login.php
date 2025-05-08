<?php
// PARTE NOVA - CÓDIGO DE DIAGNÓSTICO
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Tente detectar o erro específico
try {
    session_start();
    $admins_file = __DIR__ . "/admins.json";
    echo "Verificando arquivo: " . $admins_file . "<br>";
    
    if (!file_exists($admins_file)) {
        die("Erro: Arquivo não encontrado!");
    }
    
    $content = file_get_contents($admins_file);
    echo "Conteúdo lido com sucesso.<br>";
    
    $admins = json_decode($content, true);
    if ($admins === null) {
        die("Erro JSON: " . json_last_error_msg());
    }
    
    echo "JSON decodificado com sucesso!<br>";
    
    // PARTE ORIGINAL DO CÓDIGO (mas ajustada para usar $admins já carregado acima)
    $erro = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['usuario'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if (isset($admins[$usuario])) {
            $dados = $admins[$usuario];
            $senha_correta = $dados['primeiro_acesso'] 
                ? $senha === $dados['senha']
                : password_verify($senha, $dados['senha']);

            if ($senha_correta) {
                $_SESSION['admin'] = $usuario;

                if ($dados['primeiro_acesso']) {
                    header("Location: trocar_senha.php");
                } else {
                    header("Location: admins_dashboard.php");
                }
                exit;
            }
        }

        $erro = "Usuário ou senha inválidos.";
    }
} catch (Exception $e) {
    die("Exceção: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        p.error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Login Administrativo</h2>
    <form method="post">
        <label>Usuário: <input type="text" name="usuario" required></label>
        <label>Senha: <input type="password" name="senha" required></label>
        <button type="submit">Entrar</button>
        <?php if ($erro): ?>
            <p class="error"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>
    </form>
    <div style="text-align:center; margin-top: 20px;">
        <a href="../index.php">Voltar para o site</a>
    </div>
</body>
</html>