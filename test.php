<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Teste de Configuração Admin</h1>";

// Verificar se o arquivo de administradores existe
$admins_file = __DIR__ . "/admins.json";
echo "Verificando arquivo: " . $admins_file . "<br>";
if (file_exists($admins_file)) {
    echo "✅ Arquivo admins.json encontrado.<br>";
    
    // Verificar se o arquivo pode ser lido
    if (is_readable($admins_file)) {
        echo "✅ Arquivo admins.json é legível.<br>";
        
        // Carregar e decodificar o conteúdo
        $content = file_get_contents($admins_file);
        echo "Conteúdo do arquivo: " . htmlspecialchars(substr($content, 0, 50)) . "...<br>";
        
        $admins = json_decode($content, true);
        if ($admins !== null) {
            echo "✅ JSON válido! Encontrados " . count($admins) . " administradores.<br>";
            echo "Administradores: " . implode(", ", array_keys($admins)) . "<br>";
        } else {
            echo "❌ Erro ao decodificar JSON: " . json_last_error_msg() . "<br>";
        }
    } else {
        echo "❌ Arquivo admins.json não pode ser lido (verifique permissões).<br>";
    }
} else {
    echo "❌ Arquivo admins.json não encontrado!<br>";
}

// Verificar informações de PHP
echo "<h2>Informações do PHP</h2>";
echo "Versão PHP: " . phpversion() . "<br>";
echo "Extensão JSON: " . (extension_loaded('json') ? "Carregada" : "Não carregada") . "<br>";
echo "Diretório atual: " . __DIR__ . "<br>";

// Verificar permissões
echo "<h2>Permissões de Arquivos</h2>";
$dir = __DIR__;
echo "Permissões do diretório admin/: " . substr(sprintf('%o', fileperms($dir)), -4) . "<br>";
if (file_exists($admins_file)) {
    echo "Permissões do arquivo admins.json: " . substr(sprintf('%o', fileperms($admins_file)), -4) . "<br>";
}

// Testar sessão
echo "<h2>Teste de Sessão</h2>";
session_start();
$_SESSION['test'] = 'Teste de sessão funcionando!';
echo "Sessão iniciada com valor de teste.<br>";
echo "Session ID: " . session_id() . "<br>";
?>