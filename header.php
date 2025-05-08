<?php
session_start(); // importante para manter o login
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuadToys</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos para o botão Sair */
        .user-actions a.logout-link {
            color: #fff;
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 4px;
            margin-left: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .user-actions a.logout-link:hover {
            background-color: #c82333;
        }
        
        /* Estilos para o overlay do carrinho */
        .cart-overlay {
            position: fixed;
            top: 0;
            right: -400px;
            width: 380px;
            height: 100%;
            background-color: white;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: right 0.3s ease;
            overflow-y: auto;
        }
        
        .cart-overlay.open {
            right: 0;
        }
        
        .cart-content {
            padding: 20px;
            color: #333; /* Cor de texto escura */
        }
        
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        
        .cart-header h3 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }
        
        #close-cart {
            background: none;
            border: none;
            font-size: 1.2em;
            cursor: pointer;
            color: #777;
        }
        
        #cart-items {
            margin-bottom: 20px;
        }
        
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            color: #333;
        }
        
        .remove-item {
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .cart-footer {
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-weight: bold;
            color: #333;
        }
        
        #checkout-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        
        #checkout-btn:hover {
            background-color: #45a049;
        }
        
        .empty-cart-message {
            text-align: center;
            color: #777;
            padding: 20px 0;
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
                    <li><a href="categorias.php">Categorias</a></li>
                    <li><a href="destaques.php">Destaque</a></li>
                    <li><a href="comunidade.php">Comunidade</a></li>
                    <li><a href="contato.php">Contato</a></li>
                </ul>
            </nav>
            <div class="search-login">
                <div class="search-form">
                    <input type="text" placeholder="Buscar itens, coleções...">
                    <button>🔍</button>
                </div>
                <div class="user-actions">
                    <?php if(isset($_SESSION['cliente_id'])): ?>
                        <a href="#" class="btn"><?= htmlspecialchars($_SESSION['nome']) ?></a>
                        <a href="logout.php" class="logout-link">Sair</a>
                    <?php else: ?>
                        <a href="login.php" class="btn">Entrar / Cadastrar</a>
                    <?php endif; ?>
                    <div class="cart-icon">
                        <button id="cart-toggle">🛒</button>
                        <span id="cart-count">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Overlay do Carrinho -->
    <div class="cart-overlay">
        <div class="cart-content">
            <div class="cart-header">
                <h3>Seu Carrinho</h3>
                <button id="close-cart">✕</button>
            </div>
            <div id="cart-items">
                <!-- Itens do carrinho serão inseridos aqui via JavaScript -->
            </div>
            <div class="cart-footer">
                <div class="cart-total">
                    <span>Total:</span>
                    <span id="cart-total-price">R$ 0,00</span>
                </div>
                <button id="checkout-btn">Finalizar Compra</button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // Obter referências aos elementos do carrinho
        const cartOverlay = document.querySelector(".cart-overlay");
        const cartToggle = document.getElementById("cart-toggle");
        const closeCart = document.getElementById("close-cart");
        const cartItemsContainer = document.getElementById("cart-items");
        const cartTotalPrice = document.getElementById("cart-total-price");
        const cartCount = document.getElementById("cart-count");
        const checkoutBtn = document.getElementById("checkout-btn");
        
        // Função para verificar login
        function checkLogin() {
            return fetch('check_login.php')
                .then(response => response.json())
                .then(data => data.logged_in)
                .catch(error => {
                    console.error('Erro ao verificar login:', error);
                    return false;
                });
        }

        // Inicializar contador do carrinho
        function updateCartCount() {
            checkLogin().then(isLoggedIn => {
                if (!isLoggedIn) {
                    if (cartCount) cartCount.textContent = "0";
                    return;
                }

                fetch('get_cart.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.items) {
                            // Calcular o total de itens
                            let count = 0;
                            data.items.forEach(item => {
                                count += parseInt(item.quantidade || 1);
                            });
                            
                            // Atualizar o contador
                            if (cartCount) cartCount.textContent = count;
                        }
                    })
                    .catch(error => console.error('Erro ao carregar contador do carrinho:', error));
            });
        }

        // Buscar itens do carrinho do servidor e atualizar a interface
        function updateCartFromServer() {
            checkLogin().then(isLoggedIn => {
                if (!isLoggedIn) {
                    if (cartItemsContainer) cartItemsContainer.innerHTML = '<p class="empty-cart-message">Seu carrinho está vazio</p>';
                    if (cartTotalPrice) cartTotalPrice.textContent = "R$ 0,00";
                    return;
                }

                fetch('get_cart.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const items = data.items || [];
                            
                            if (cartItemsContainer) {
                                cartItemsContainer.innerHTML = "";
                                let total = 0;
                                
                                if (items.length === 0) {
                                    cartItemsContainer.innerHTML = '<p class="empty-cart-message">Seu carrinho está vazio</p>';
                                } else {
                                    items.forEach(item => {
                                        const cartItem = document.createElement("div");
                                        cartItem.classList.add("cart-item");
                                        
                                        // Usar os campos corretos ou fallbacks
                                        const nome = item.nome || "Produto";
                                        const quantidade = parseInt(item.quantidade || 1);
                                        const preco = parseFloat(item.preco || 0);
                                        const itemId = item.carrinho_id || item.id;
                                        
                                        cartItem.innerHTML = `
                                            <span>${nome} (x${quantidade})</span>
                                            <span>R$ ${(preco * quantidade).toFixed(2).replace('.', ',')}</span>
                                            <button class="remove-item" data-id="${itemId}">X</button>
                                        `;
                                        cartItemsContainer.appendChild(cartItem);
                                        total += preco * quantidade;
                                    });
                                }
                                
                                if (cartTotalPrice) {
                                    cartTotalPrice.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
                                }
                                
                                // Adicionar listeners aos botões de remover
                                document.querySelectorAll(".remove-item").forEach(button => {
                                    button.addEventListener("click", (e) => {
                                        const id = e.target.dataset.id;
                                        removeFromCartServer(id);
                                    });
                                });
                            }
                        }
                    })
                    .catch(error => console.error('Erro ao carregar carrinho:', error));
            });
        }

        // Remover produto do carrinho
        function removeFromCartServer(id) {
            fetch(`remove_from_cart.php?id=${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartFromServer();
                        updateCartCount();
                    }
                })
                .catch(error => console.error('Erro ao remover item:', error));
        }

        // Configurar eventos do carrinho se os elementos existirem
        if (cartToggle && closeCart && cartOverlay) {
            // Abrir carrinho
            cartToggle.addEventListener("click", (e) => {
                e.stopPropagation(); // Evitar propagação do clique
                cartOverlay.classList.add("open");
                updateCartFromServer(); // Atualizar ao abrir
            });

            // Fechar carrinho
            closeCart.addEventListener("click", () => {
                cartOverlay.classList.remove("open");
            });
            
            // Fechar carrinho ao clicar fora
            document.addEventListener("click", (e) => {
                if (cartOverlay.classList.contains("open") && 
                    !cartOverlay.contains(e.target) && 
                    e.target !== cartToggle) {
                    cartOverlay.classList.remove("open");
                }
            });
        }

        // Botão de finalizar compra
        if (checkoutBtn) {
            checkoutBtn.addEventListener("click", () => {
                checkLogin().then(isLoggedIn => {
                    if (!isLoggedIn) {
                        window.location.href = 'login.php?redirect=checkout.php';
                    } else {
                        window.location.href = 'checkout.php';
                    }
                });
            });
        }

        // Verificar se um produto foi adicionado (status=adicionado na URL)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'adicionado') {
            // Mostrar mensagem de sucesso
            setTimeout(() => {
                alert('Produto adicionado ao carrinho com sucesso!');
            }, 300);
        }

        // Inicializar o contador do carrinho ao carregar a página
        updateCartCount();
    });
    </script>
</header>