<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuadToys - Seu Portal de Colecionáveis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

    <section class="hero">
        <div class="container">
            <h1>O Universo dos Colecionáveis em um só lugar</h1>
            <p>Descubra itens colecionáveis raros e únicos. 
               Junte-se a milhares de colecionadores apaixonados.</p>
            <div class="hero-buttons">
                <button class="btn">Explorar Coleções</button>
            </div>
        </div>
    </section>

    <section class="categories">
        <div class="container">
            <h2 class="section-title">Categorias Populares</h2>
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-img">
                        <img src="images/card.jpg" alt="Cards Colecionáveis">
                    </div>
                    <div class="category-content">
                        <h3>Cards Colecionáveis</h3>
                        <p>Magic, Pokémon, Yu-Gi-Oh e mais</p>
                        <a href="#" style="color: #e74c3c;">Ver coleção →</a>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-img">
                        <img src="images/51gVG8DY1lL._AC_.jpg" alt="Action Figures">
                    </div>
                    <div class="category-content">
                        <h3>Action Figures</h3>
                        <p>Super-heróis, animes, games e filmes</p>
                        <a href="#" style="color: #e74c3c;">Ver coleção →</a>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-img">
                        <img src="images/moedas.jpg" alt="Moedas e Notas">
                    </div>
                    <div class="category-content">
                        <h3>Moedas e Notas</h3>
                        <p>Moedas raras, notas antigas e especiais</p>
                        <a href="#" style="color: #e74c3c;">Ver coleção →</a>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-img">
                        <img src="images/images.jpeg" alt="Quadrinhos">
                    </div>
                    <div class="category-content">
                        <h3>Quadrinhos</h3>
                        <p>Edições raras, primeiras edições e mais</p>
                        <a href="#" style="color: #e74c3c;">Ver coleção →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="feature-products">
        <div class="container">
            <h2 class="section-title">Itens em Destaque</h2>
            <div class="products-grid">
                <div class="product-card" data-id="1" data-name="Charizard 1ª Edição PSA 9" data-price="15000.00">
                    <div class="product-img">
                        <img src="images/charizard.jpg" alt="Charizard Raro">
                        <div class="product-badge">RARO</div>
                    </div>
                    <div class="product-content">
                        <h3>Charizard 1ª Edição PSA 9</h3>
                        <div class="price">R$ 15.000,00</div>
                        <div class="meta">
                            <span>Pokemon Cards</span>
                            <span>3 Interessados</span>
                        </div>
                        <button class="add-to-cart btn">Adicionar ao Carrinho</button>
                    </div>
                </div>
                <div class="product-card" data-id="2" data-name="Batman Hot Toys Exclusivo" data-price="3500.00">
                    <div class="product-img">
                        <img src="images/batman.jpg" alt="Action Figure Rara">
                    </div>
                    <div class="product-content">
                        <h3>Batman Hot Toys Exclusivo</h3>
                        <div class="price">R$ 3.500,00</div>
                        <div class="meta">
                            <span>Action Figures</span>
                            <span>7 Interessados</span>
                        </div>
                        <button class="add-to-cart btn">Adicionar ao Carrinho</button>
                    </div>
                </div>
                <div class="product-card" data-id="3" data-name="Moeda Dom Pedro II 1869" data-price="8750.00">
                    <div class="product-img">
                        <img src="images/dompedro.jpeg" alt="Moeda Rara">
                        <div class="product-badge">ÚNICA</div>
                    </div>
                    <div class="product-content">
                        <h3>Moeda Dom Pedro II 1869</h3>
                        <div class="price">R$ 8.750,00</div>
                        <div class="meta">
                            <span>Numismática</span>
                            <span>12 Interessados</span>
                        </div>
                        <button class="add-to-cart btn">Adicionar ao Carrinho</button>
                    </div>
                </div>
                <div class="product-card" data-id="4" data-name="Amazing Fantasy #15 CGC 4.5" data-price="120000.00">
                    <div class="product-img">
                        <img src="images/amazingfantasy.jpeg" alt="Quadrinho Raro">
                    </div>
                    <div class="product-content">
                        <h3>Amazing Fantasy #15 CGC 4.5</h3>
                        <div class="price">R$ 120.000,00</div>
                        <div class="meta">
                            <span>Quadrinhos</span>
                            <span>5 Interessados</span>
                        </div>
                        <button class="add-to-cart btn">Adicionar ao Carrinho</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="call-to-action">
        <div class="container">
            <h2>Fique por dentro das novidades!</h2>
            <p>Receba alertas sobre itens raros, promoções exclusivas e dicas para colecionadores.</p>
            <form class="newsletter">
                <input type="email" placeholder="Seu melhor e-mail">
                <button type="submit">Inscrever-se</button>
            </form>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <div id="cart-overlay" class="cart-overlay">
        <div class="cart-header">
            <h2>Seu Carrinho</h2>
            <button id="close-cart" class="close-cart">×</button>
        </div>
        <div id="cart-items" class="cart-items">
            <p class="empty-cart-message">Seu carrinho está vazio</p>
        </div>
        <div class="cart-total">
            <span>Total:</span>
            <span id="cart-total-price">R$ 0,00</span>
        </div>
        <button id="checkout-btn">Finalizar Compra</button>
    </div>
    <script src="script.js" defer></script>
</body>
</html>
