<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - QuadToys</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .contact-page {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            background-color: #f5f5f5;
            padding: 2rem;
        }
        .contact-container {
            background-color: white;
            padding: 3rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        .contact-container h1 {
            color: #2c3e50;
            margin-bottom: 2rem;
        }
        .contact-info {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centralize os itens */
            gap: 1.5rem; /* Aumente o espaçamento entre os itens */
            line-height: 1.6; /* Adicione espaçamento de linha */
        }
        .contact-info p {
            color: #34495e;
            font-size: 1.1rem;
            text-align: center; /* Centralize o texto */
            max-width: 300px; /* Limite a largura para melhor legibilidade */
        }
        .contact-info a {
            color: #e74c3c;
            text-decoration: none;
            transition: color 0.3s;
        }
        .contact-info a:hover {
            color: #c0392b;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">Quad<span>Toys</span></div>
                <nav>
                    <ul>
                        <li><a href="index.php">Início</a></li>
                        <li><a href="#">Categorias</a></li>
                        <li><a href="#">Destaque</a></li>
                        <li><a href="#">Raridades</a></li>
                        <li><a href="#">Comunidade</a></li>
                        <li><a href="contato.php">Contato</a></li>
                    </ul>
                </nav>
                <div class="search-login">
                    <div class="search-form">
                        <input type="text" placeholder="Buscar itens, coleções...">
                        <button>🔍</button>
                    </div>
                    <button class="btn">Entrar / Cadastrar</button>
                </div>
            </div>
        </div>
    </header>

    <div class="contact-page">
        <div class="contact-container">
            <h1>Entre em Contato</h1>
            <div class="contact-info">
                <p>📧 E-mail: <a href="mailto:contato@quadtoys.com.br">contato@quadtoys.com.br</a></p>
                <p>📞 Telefone: <a href="tel:+551935784125">(19) 3578-4125</a></p>
                <p>💬 WhatsApp: <a href="https://wa.me/5519982647391">(19) 9 8264-7391</a></p>
                <p>📍 Endereço para Correspondência:<br>
                CEP 13015-130<br>
                Rua quatorze de dezembro, 80, Apto 67<br>
                Centro, Campinas - SP</p>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>QuadToys</h3>
                    <p>O maior portal de colecionáveis do Brasil. Conectamos colecionadores e entusiastas em uma comunidade apaixonada.</p>
                    <div class="social-links">
                        <a href="#">F</a>
                        <a href="#">I</a>
                        <a href="#">T</a>
                        <a href="#">Y</a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Navegação</h3>
                    <ul>
                        <li><a href="index.php">Início</a></li>
                        <li><a href="#">Categorias</a></li>
                        <li><a href="#">Destaques</a></li>
                        <li><a href="#">Raridades</a></li>
                        <li><a href="#">Comunidade</a></li>
                        <li><a href="contato.php">Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                &copy; 2025 QuadToys - Todos os direitos reservados
            </div>
        </div>
    </footer>
</body>
</html>