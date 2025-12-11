<?php
// Define a raiz do projeto (PROJETO AGROTEC) subindo 1 nível a partir de views.
// Linha 1: Inicia a sessão (necessário para o sistema de login)
session_start();

// Linha 2: Define o separador correto para o sistema operacional
$DS = DIRECTORY_SEPARATOR; 

// CALCULA A RAIZ DO PROJETO (views -> PROJETO AGROTEC)
$project_root = dirname(__DIR__, 1);

// CONSTRÓI O CAMINHO ABSOLUTO PARA O DB
$db_path = $project_root . $DS . 'config' . $DS . 'db.php';

// FORÇA A INCLUSÃO DO ARQUIVO DE CONEXÃO
require_once $db_path;


// --- Dados FIXOS (Cards de Ícones) ---
$icon_cards = [
    [
        'img_src' => '../public/assets/img/icons/encomenda.png',
        'img_alt' => 'Retire sua Encomenda',
        'title' => 'Resgate a Encomenda',
        'link' => '#' 
    ],
    [
        'img_src' => '../public/assets/img/icons/local.png',
        'img_alt' => 'Ponto de Retirada',
        'title' => 'Ponto de Retirada',
        'link' => '#'
    ],
  [
    'img_src' => '../../public/assets/img/icons/mais-vendidos.png',
    'img_alt' => 'Produtos Mais Vendidos',
    'title' => 'Mais Vendidos',
    'link' => '../../controllers/carrot.php'
],
    [
        'img_src' => '../public/assets/img/icons/pagamento.png',
        'img_alt' => 'Meios de Pagamento',
        'title' => 'Meios de Pagamento',
        'link' => '#'
    ]
];

// --- Lógica para buscar os produtos do banco de dados usando PDO ---
$produtos = []; 

try {
    $pdo = getPDO(); 
    
    $stmt = $pdo->prepare("SELECT nome, preco, imagem_url, link_detalhe FROM produtos ORDER BY id_produtoPK DESC LIMIT 4");
    
    $stmt->execute();
    
    foreach ($stmt->fetchAll() as $row) {
        $produtos[] = [
            'img_src' => htmlspecialchars($row['imagem_url'] ?? ''),
            'img_alt' => htmlspecialchars($row['nome']),
            'name' => htmlspecialchars($row['nome']),
            'price' => 'R$ ' . number_format($row['preco'], 2, ',', '.'),
            'link' => htmlspecialchars($row['link_detalhe'] ?? '#')
        ];
    }
} catch (Exception $e) {
    // A página não trava se houver erro no banco de dados, apenas lista zero produtos.
    error_log("Erro ao buscar produtos: " . $e->getMessage());
    $produtos = []; 
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroTech | Seu E-commerce Agrícola</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/estilo.css">
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
                <a href="cesta.php">Cesta</a>
                <a href="#">Minha Conta</a>
                <a href="#">Ajuda</a>
                <a href="#">Sobre</a>
            </nav>
            
            <div class="user-access">
                <div class="perfil">
                    <button id="perfil-btn">
                        <img src="../public/assets/img/perfil/Perfil1.png" alt="Perfil do Usuário">
                    </button>
                </div>
                
                <div id="options" class="options-dropdown hidden">
                    <a href="cadastro.html" class="action-btn">Criar Conta</a>
                    <a href="login.php" class="action-btn action-btn-alt">Entrar na Conta</a>
                </div>
                
                <img id="toggleButton" src="../public/assets/img/icons/next.png" alt="Abrir/Fechar Barra" class="toggle-sidebar" />
            </div>
        </div>
        
    </header>

    <nav class="menu">
        <a href="#">Cesta</a>
        <a href="#">Minha Conta</a>
        <a href="#">Ajuda</a>
        <a href="#">Sobre</a>
    </nav>

    <main class="main-content"> 
        
        <section class="carousel" aria-label="Gallery">
            <ol class="carousel__viewport">
                <li id="carousel__slide1" class="carousel__slide">
                    <div class="carousel__snapper">
                        <img src="../public/assets/img/coisa1.jpeg" alt="Banner: Oferta de Produtos Frescos">
                    </div>
                </li>
                <li id="carousel__slide2" class="carousel__slide">
                    <div class="carousel__snapper">
                        <img src="../public/assets/img/coisa2.jpg" alt="Banner: Descrição da imagem 2">
                    </div>
                </li>
                <li id="carousel__slide3" class="carousel__slide">
                    <div class="carousel__snapper">
                        <img src="../public/assets/img/coisa3.jpg" alt="Banner: Descrição da imagem 3">
                    </div>
                </li>
            </ol>
        </section>
        
        <section class="info-cards-section">
            <div class="list-card">
            <?php foreach ($icon_cards as $card): // Exibe os cards de ícones fixos ?>
                <div class="card-container">
                    <img src="../public/assets/img/<?= $card['img_src'] ?>" alt="<?= $card['img_alt'] ?>"> 
                    <h3><?= $card['title'] ?></h3>
                    <button class="btn-secondary">Mostrar</button>
                </div>
            <?php endforeach; ?>
            </div>
        </section>
        
        <section class="products-section">
            <h2>Mais indicados para você</h2>
            <div class="product-list">
            <?php if (empty($produtos)): // Se não houver produtos no DB ?>
                <p>Nenhum produto encontrado no momento. Verifique a conexão com o banco de dados e se a tabela 'produtos' está preenchida.</p>
            <?php else: ?>
                <?php foreach ($produtos as $produto): // Exibe os produtos buscados no DB ?>
                    <div class="product-card">
                        <img src="<?= $produto['img_src'] ?>" alt="<?= $produto['img_alt'] ?>">
                        <h3><?= $produto['name'] ?></h3>
                        <p class="price"><?= $produto['price'] ?></p>
                        <a href="<?= $produto['link'] ?>" class="btn-buy">Comprar</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>Desenvolvido por Felipe Dias, Pedro Neto, Endryo Matos e Felipe Madson &copy; 2025 AgroTech</p>
    </footer>
    <script src="../public/assets/js/javinha.js"></script>
</body>
</html>