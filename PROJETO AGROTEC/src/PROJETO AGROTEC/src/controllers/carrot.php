<?php
// Define a raiz do projeto (PROJETO AGROTEC) subindo 1 nível a partir de views.
session_start();

// Define o separador correto para o sistema operacional
$DS = DIRECTORY_SEPARATOR; 
$project_root = dirname(__DIR__, 1);

// CONSTRÓI O CAMINHO ABSOLUTO PARA O DB
$db_path = $project_root . $DS . 'config' . $DS . 'db.php';

// FORÇA A INCLUSÃO DO ARQUIVO DE CONEXÃO
require_once $db_path;

// >>> CORREÇÃO CRÍTICA DE CONEXÃO <<<
try {
    $pdo = getPDO(); // CRIA E OBTÉM O OBJETO PDO
} catch (Exception $e) {
    // Se a conexão falhar, exibe uma mensagem crítica.
    die('Erro de conexão com o banco de dados. Verifique o XAMPP e o db.php: ' . $e->getMessage());
}
// >>> FIM DA CORREÇÃO DE CONEXÃO <<<

// LÓGICA DE BUSCA DO PRODUTO (Busca a Cenoura)
try {
    // Se você estiver passando o ID do produto via URL (GET), use: $id = $_GET['id'] ?? 1;
    $stmt = $pdo->prepare('SELECT id_produtoPK, nome, descricao, quantidade, preco, imagem_url FROM produtos WHERE nome = ? LIMIT 1');
    $stmt->execute(['Cenoura']);
    $product = $stmt->fetch(PDO::FETCH_ASSOC); 
} catch (Exception $e) {
    error_log("Erro ao buscar produto: " . $e->getMessage());
    $product = false;
}

// Valores padrão caso o produto não exista no banco (Fallback)
if (!$product) {
    $product = [
        'id_produtoPK' => 1,
        'nome' => 'Produto Não Encontrado',
        'descricao' => 'Verifique a tabela de produtos no banco de dados.',
        'quantidade' => 0,
        'preco' => '0.00'
    ];
}

// Formatação de Valores para Exibição
$preco_formatado = number_format((float)$product['preco'], 2, ',', '.');
// Evita divisão por zero se o preço for 0
$parcela_formatada = number_format((float)$product['preco'] > 0 ? (float)$product['preco']/12 : 0, 2, ',', '.');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroTech - <?php echo htmlspecialchars($product['nome']); ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/carrot.css">
</head>
<body>
    
    <header class="header">
        <div class="header-content">
            <a href="index.php" class="logo">
                <img src="../public/assets/img/logo/incra.png" alt="AgroTech Logo">
            </a>
            <div class="search-bar">
                <input type="text" placeholder="Pesquisar na AgroTech...">
                <button>Pesquisar</button>
            </div>

            <nav class="user-nav">
                <a href="categorias.html" class="nav-link">Cesta</a>
                <a href="ofertas.html" class="nav-link">Sobre</a>
                <a href="vendedores.html" class="nav-link">Vender</a>
                <a href="ajuda.html" class="nav-link">Ajuda</a>
            </nav>
            
            <div class="user-access">
                <div class="perfil">
                    <button id="perfil-btn" style="background: none; border: none; padding: 0;">
                        <img src="../public/assets/img/perfil/Perfil1.png" alt="Perfil do Usuário" class="user-icon">
                    </button>
                </div>
                
                <div id="options" class="options-dropdown hidden">
                    <a href="login.html" class="action-btn">Criar Conta</a>
                    <a href="entrar.html" class="action-btn action-btn-alt">Entrar na Conta</a>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="product-section">
            <div class="product-gallery">
                <div class="thumbnail-list">
                    <img src="../public/assets/img/cenoura3].png" alt="Cenoura Thumbnail 1" class="thumbnail active">
                    <img src="../public/assets/img/image1.png" alt="Cenoura Thumbnail 2" class="thumbnail">
                    <img src="../public/assets/img/image2.png" alt="Cenoura Thumbnail 3" class="thumbnail">
                    <img src="../public/assets/img/image3.png" alt="Cenoura Thumbnail 4" class="thumbnail">
                    <img src="../public/assets/img/image4.png" alt="Cenoura Thumbnail 5" class="thumbnail">
                </div>
                <div class="main-image">
                    <img src="../public/assets/img/cenoura3].png" alt="Cenoura Principal" id="mainImage">
                </div>
            </div>
            </section>
            <section class="seller-products">
                </section>
        </div>

        <aside class="product-info">
            <h1><?php echo htmlspecialchars($product['nome']); ?></h1>
            <div class="rating">
                </div>
            
            <div class="price-container">
                <p class="price">R$ <?php echo $preco_formatado; ?></p>
                <p class="installments">em 12x R$ <?php echo $parcela_formatada; ?></p>
            </div>
            
            <p><?php echo htmlspecialchars($product['descricao']); ?></p>

            <div class="stock-info">
                <p>Estoque: <?php echo (int)$product['quantidade']; ?></p>
            </div>
            
            <button class="buy-button" id="pagar-mercadopago" data-id="<?php echo (int)$product['id_produtoPK']; ?>">Comprar Agora</button>
            <button class="cart-button" id="add-to-cart" data-id="<?php echo (int)$product['id_produtoPK']; ?>">Adicionar ao Carrinho</button>
            
            </aside>
    </main>

    <section class="reviews-section">
        </section>

    <body style="display: flex; flex-direction: column; min-height: 100vh;">
    
    <main class="main-content" style="flex-grow: 1;"> 
        </main>

    <footer class="footer">
        <p>Desenvolvido por Felipe Dias, Pedro Neto, Endryo Matos e Felipe Madson &copy; 2025 AgroTech</p>
    </footer>

    <script src="../public/assets/js/javinha.js"></script>
    <script src="../public/assets/js/pagamento.js"></script>
</body>
</html>