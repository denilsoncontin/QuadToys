document.addEventListener("DOMContentLoaded", () => {
    const cartOverlay = document.querySelector(".cart-overlay");
    const cartToggle = document.getElementById("cart-toggle");
    const closeCart = document.getElementById("close-cart");
    const cartItemsContainer = document.querySelector(".cart-items");
    const cartTotalPrice = document.getElementById("cart-total-price");
    const cartCount = document.getElementById("cart-count"); // Novo contador no ícone do carrinho
    let cart = [];

    if (cartToggle && closeCart) {
        cartToggle.addEventListener("click", () => {
            cartOverlay.classList.add("open");
        });

        closeCart.addEventListener("click", () => {
            cartOverlay.classList.remove("open");
        });
    }

    function addToCart(item) {
        const existingItem = cart.find(cartItem => cartItem.id === item.id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({ ...item, quantity: 1 });
        }
        updateCart();
    }

    function updateCart() {
        cartItemsContainer.innerHTML = "";
        let total = 0;
        let itemCount = 0; // Contador de itens no carrinho

        cart.forEach(item => {
            const cartItem = document.createElement("div");
            cartItem.classList.add("cart-item");
            cartItem.innerHTML = `
                <span>${item.name} (x${item.quantity})</span>
                <span>R$ ${(item.price * item.quantity).toFixed(2)}</span>
                <button class="remove-item" data-id="${item.id}">X</button>
            `;
            cartItemsContainer.appendChild(cartItem);
            total += item.price * item.quantity;
            itemCount += item.quantity; // Soma a quantidade total de itens
        });

        cartTotalPrice.textContent = `R$ ${total.toFixed(2)}`;
        cartCount.textContent = itemCount; // Atualiza o número no ícone do carrinho

        document.querySelectorAll(".remove-item").forEach(button => {
            button.addEventListener("click", (e) => {
                removeFromCart(e.target.dataset.id);
            });
        });
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        updateCart();
    }

    document.body.addEventListener("click", (e) => {
        if (e.target.classList.contains("add-to-cart")) {
            console.log("Botão 'Adicionar ao Carrinho' clicado!");

            const productCard = e.target.closest(".product-card");

            if (!productCard) {
                console.error("Erro: Produto não encontrado para este botão.");
                return;
            }

            const item = {
                id: productCard.dataset.id,
                name: productCard.dataset.name,
                price: parseFloat(productCard.dataset.price)
            };

            console.log("Item adicionado:", item);
            addToCart(item);
        }
    });

    document.addEventListener("click", (e) => {
        if (cartOverlay && cartOverlay.classList.contains("open") && 
            !cartOverlay.contains(e.target) && 
            e.target !== cartToggle) {
            cartOverlay.classList.remove("open");
        }
    });
});
