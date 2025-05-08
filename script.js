document.addEventListener("DOMContentLoaded", () => {
    const cartOverlay = document.querySelector(".cart-overlay");
    const cartToggle = document.getElementById("cart-toggle");
    const closeCart = document.getElementById("close-cart");
    const cartItemsContainer = document.getElementById("cart-items");
    const cartTotalPrice = document.getElementById("cart-total-price");
    const cartCount = document.getElementById("cart-count");
    const checkoutBtn = document.getElementById("checkout-btn");
    
    let cart = [];

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

    // Abrir/fechar carrinho
    if (cartToggle && closeCart) {
        cartToggle.addEventListener("click", () => {
            cartOverlay.classList.add("open");
            updateCartFromServer(); // Atualiza ao abrir
        });

        closeCart.addEventListener("click", () => {
            cartOverlay.classList.remove("open");
        });
    }

    // Buscar itens do carrinho do servidor
    function updateCartFromServer() {
        checkLogin().then(isLoggedIn => {
            if (!isLoggedIn) {
                updateCartUI([]); // Carrinho vazio para não logados
                return;
            }

            fetch('get_cart.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cart = data.items;
                        updateCartUI(cart);
                    }
                })
                .catch(error => console.error('Erro ao carregar carrinho:', error));
        });
    }

    // Adicionar produto ao carrinho
    function addToCartServer(item) {
        checkLogin().then(isLoggedIn => {
            if (!isLoggedIn) {
                window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
                return;
            }

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Linha adicionada para identificar requisição AJAX
                },
                body: JSON.stringify(item)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartFromServer();
                    // Mostrar mensagem de sucesso
                    alert('Produto adicionado ao carrinho!');
                } else {
                    console.error('Erro ao adicionar produto:', data.message);
                    // Mostrar mensagem de erro ao usuário
                    alert('Erro: ' + (data.message || 'Não foi possível adicionar o produto ao carrinho.'));
                }
            })
            .catch(error => console.error('Erro na requisição:', error));
        });
    }

    // Remover produto do carrinho
    function removeFromCartServer(id) {
        fetch(`remove_from_cart.php?id=${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Linha adicionada para identificar requisição AJAX
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartFromServer();
                }
            })
            .catch(error => console.error('Erro ao remover item:', error));
    }

    // Atualizar interface do carrinho
    function updateCartUI(items) {
        if (!cartItemsContainer) return;
        
        cartItemsContainer.innerHTML = "";
        let total = 0;
        let count = 0;

        if (items.length === 0) {
            cartItemsContainer.innerHTML = '<p class="empty-cart-message">Seu carrinho está vazio</p>';
        } else {
            items.forEach(item => {
                const cartItem = document.createElement("div");
                cartItem.classList.add("cart-item");
                cartItem.innerHTML = `
                    <span>${item.nome} (x${item.quantidade})</span>
                    <span>R$ ${(parseFloat(item.preco) * item.quantidade).toFixed(2).replace('.', ',')}</span>
                    <button class="remove-item" data-id="${item.carrinho_id}">X</button>
                `;
                cartItemsContainer.appendChild(cartItem);
                total += parseFloat(item.preco) * item.quantidade;
                count += parseInt(item.quantidade);
            });
        }

        if (cartTotalPrice) {
            cartTotalPrice.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
        }
        
        if (cartCount) {
            cartCount.textContent = count;
        }

        // Adicionar listeners aos botões de remover
        document.querySelectorAll(".remove-item").forEach(button => {
            button.addEventListener("click", (e) => {
                const id = e.target.dataset.id;
                removeFromCartServer(id);
            });
        });
    }

    // Listener para botões "Adicionar ao Carrinho"
    document.body.addEventListener("click", (e) => {
        if (e.target.classList.contains("add-to-cart")) {
            const productCard = e.target.closest(".product-card");
            
            if (!productCard) {
                console.error("Produto não encontrado");
                return;
            }

            const product = {
                produto_id: productCard.dataset.id,
                nome: productCard.dataset.name,
                preco: parseFloat(productCard.dataset.price),
                quantidade: 1 // Adicionado campo quantidade explicitamente
            };

            addToCartServer(product);
        }
    });

    // Fechar carrinho ao clicar fora
    document.addEventListener("click", (e) => {
        if (cartOverlay && cartOverlay.classList.contains("open") && 
            !cartOverlay.contains(e.target) && 
            e.target !== cartToggle) {
            cartOverlay.classList.remove("open");
        }
    });

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

    // Inicializar carrinho
    updateCartFromServer();
});