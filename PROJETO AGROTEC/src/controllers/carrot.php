<?php
require_once __DIR__ . '/db.php';
$pdo = getPDO();

// Buscar produto 'Cenoura' como exemplo. Ajuste a query conforme seu esquema ou passe id via GET
try {
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE nome = ? LIMIT 1');
    $stmt->execute(['Cenoura']);
    $product = $stmt->fetch();
} catch (Exception $e) {
    $product = false;
}

// Valores padrão caso não exista no banco
if (!$product) {
    $product = [
        'id_produtoPK' => 1,
        'nome' => 'Cenoura',
        'descricao' => 'Cenoura fresca direto do produtor',
        'quantidade' => 86,
        'preco' => '29.90'
    ];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroTec - <?php echo htmlspecialchars($product['nome']); ?></title>
    <link rel="stylesheet" href="carrot.css">
    <meta name="referrer" content="no-referrer">
</head>
<body>
    <!-- ... mantive o HTML original, só troquei os valores dinâmicos -->
    <header class="header">
        <div class="logo">
            <img src="assets/incra_logo_version_branca-removebg-preview 3.png" alt="INCRA Logo" class="logo-img">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Pesquisar na AgroTec.com">
        </div>
        <div class="user-section">
            <span>Olá Username</span>
            <img src="assets/Perfil.png" alt="User" class="user-icon">
        </div>
    </header>

    <main class="main-content">
        <div class="product-section">
            <div class="product-gallery">
                <div class="thumbnail-list">
                    <img src="assets/CENOURA.png" alt="Cenoura Thumbnail 1" class="thumbnail">
                    <img src="assets/image1.png" alt="Cenoura Thumbnail 2" class="thumbnail">
                </div>
                <div class="main-image">
                    <img src="assets/CENOURA.png" alt="Cenoura Principal" id="mainImage">
                </div>
            </div>

            <!-- demais seções omitidas para brevidade -->
        </div>

        <aside class="product-info">
            <span class="badge new">Novo</span>
            <span class="badge bestseller">Mais vendido</span>
            <h1><?php echo htmlspecialchars($product['nome']); ?></h1>
            <div class="rating">
                <div class="stars">★★★★★</div>
                <span class="rating-value">4,5</span>
                <span class="reviews">(3.033 avaliações)</span>
            </div>
            <div class="price-container">
                <p class="price">R$ <?php echo number_format((float)$product['preco'], 2, ',', '.'); ?></p>
                <p class="installments">em 12x R$ <?php echo number_format((float)$product['preco']/12, 2, ',', '.'); ?></p>
            </div>
            <div class="delivery-info">
                <p>Chegará grátis amanhã</p>
                <p>Mais formas de entrega</p>
                <p>Retire grátis a partir de amanhã</p>
                <a href="#" class="map-link">Ver no mapa</a>
            </div>
            <div class="return-info">
                <p>Devolução grátis</p>
                <a href="#" class="learn-more">Saiba Mais</a>
            </div>
            <div class="stock-info">
                <p>Estoque: <?php echo (int)$product['quantidade']; ?></p>
            </div>
            <button class="buy-button" id="pagar-mercadopago" data-id="<?php echo (int)$product['id_produtoPK']; ?>">Comprar Agora</button>
            <button class="cart-button" id="add-to-cart" data-id="<?php echo (int)$product['id_produtoPK']; ?>">Adicionar ao Carrinho</button>
            <div class="seller-info">
                <p>Vendido por José Anchieta</p>
                <div class="warranty">
                    <span class="warranty-icon">⚡</span>
                    <p>90 dias de garantia</p>
                </div>
            </div>
        </aside>
    </main>

    <section class="reviews-section">
        <h2>Opiniões do Produto</h2>
        <!-- conteúdo omitido -->
    </section>

    <script>
    // Funções mínimas para adicionar ao carrinho / comprar usando endpoints PHP
    async function postJSON(url, data) {
        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return res.json();
    }

    document.getElementById('add-to-cart').addEventListener('click', async function() {
        const id = this.dataset.id;
        const res = await postJSON('add_to_cart.php', { product_id: id, quantity: 1 });
        alert(res.success ? 'Adicionado ao carrinho' : 'Erro: ' + (res.error || '')); 
    });

    document.getElementById('pagar-mercadopago').addEventListener('click', async function() {
        const id = this.dataset.id;
        const res = await postJSON('buy.php', { product_id: id, quantity: 1, payment_method: 'boleto' });
        if (res.success) {
            alert('Compra registrada. Venda ID: ' + res.venda_id);
            // aqui redirecionar para checkout real ou gateway
        } else {
            alert('Erro: ' + (res.error || '')); 
        }
    });
    </script>
</body>
</html>
