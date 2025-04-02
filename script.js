// Debug para verificar carregamento do script
console.log("Script carregado!");

document.addEventListener("DOMContentLoaded", () => {
    // Variáveis do carrinho
    const cartOverlay = document.querySelector(".cart-overlay");
    const cartToggle = document.getElementById("cart-toggle");
    const closeCart = document.getElementById("close-cart");
    const cartItemsContainer = document.querySelector(".cart-items");
    const cartTotalPrice = document.getElementById("cart-total-price");
    let cart = [];

    // Variáveis do menu responsivo
    const menuToggle = document.getElementById("menu-toggle");
    const nav = document.querySelector("nav ul");

    // Abrir e fechar carrinho
    cartToggle.addEventListener("click", () => {
        cartOverlay.classList.add("open");
    });

    closeCart.addEventListener("click", () => {
        cartOverlay.classList.remove("open");
    });

    // Menu responsivo
    menuToggle.addEventListener("click", () => {
        nav.classList.toggle("active");
    });

    // Adicionar item ao carrinho
    function addToCart(item) {
        const existingItem = cart.find(cartItem => cartItem.id === item.id);
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({...item, quantity: 1});
        }
        updateCart();
    }

    // Atualizar carrinho
    function updateCart() {
        cartItemsContainer.innerHTML = "";
        let total = 0;
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
        });
        cartTotalPrice.textContent = `R$ ${total.toFixed(2)}`;

        document.querySelectorAll(".remove-item").forEach(button => {
            button.addEventListener("click", (e) => {
                removeFromCart(e.target.dataset.id);
            });
        });
    }

    // Remover item do carrinho
    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        updateCart();
    }

    // Exemplo de adição ao carrinho (modifique conforme necessário)
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", (e) => {
            const item = {
                id: e.target.dataset.id,
                name: e.target.dataset.name,
                price: parseFloat(e.target.dataset.price)
            };
            addToCart(item);
        });
    });
});
