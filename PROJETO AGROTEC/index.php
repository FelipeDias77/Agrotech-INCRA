<?php
// Inclui o arquivo de conexão PDO e a função getPDO()
include_once 'db.php'; 

// --- Dados FIXOS (Cards de Ícones) ---
$icon_cards = [
    [
        'img_src' => 'icons/encomenda.png',
        'img_alt' => 'Retire sua Encomenda',
        'title' => 'Resgate a Encomenda',
        'link' => '#' 
    ],
    [
        'img_src' => 'icons/local.png',
        'img_alt' => 'Ponto de Retirada',
        'title' => 'Ponto de Retirada',
        'link' => '#'
    ],
    [
        'img_src' => 'icons/mais-vendidos.png',
        'img_alt' => 'Produtos Mais Vendidos',
        'title' => 'Mais Vendidos',
        'link' => '#'
    ],
    [
        'img_src' => 'icons/pagamento.png',
        'img_alt' => 'Meios de Pagamento',
        'title' => 'Meios de Pagamento',
        'link' => '#'
    ]
];

// --- Lógica para buscar os produtos do banco de dados usando PDO ---
$produtos = []; 

try {
    $pdo = getPDO(); 
    
    // Usando 'id_produtoPK' e as colunas 'preco', 'imagem_url', 'link_detalhe'
    $stmt = $pdo->prepare("SELECT nome, preco, imagem_url, link_detalhe FROM produtos ORDER BY id_produtoPK DESC LIMIT 4");
    
    $stmt->execute();
    
    foreach ($stmt->fetchAll() as $row) {
        $produtos[] = [
            'img_src' => htmlspecialchars($row['imagem_url'] ?? ''), // Null coalescing para segurança
            'img_alt' => htmlspecialchars($row['nome']),
            'name' => htmlspecialchars($row['nome']),
            'price' => 'R$ ' . number_format($row['preco'], 2, ',', '.'),
            'link' => htmlspecialchars($row['link_detalhe'] ?? '#')
        ];
    }
} catch (Exception $e) {
    error_log("Erro ao buscar produtos: " . $e->getMessage());
    $produtos = []; 
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroTech</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header class="header">
     <a href="https://www.gov.br/incra/pt-br" class="icon-btn">
        <img src="logo/incra.png" alt="Incra">
         <span class="icon-text" id="typed-text"></span>
         </a>
         <div class="search-bar">
            <input type="text" placeholder="Pesquisar na AgroTech...">
            <button>Pesquisar</button>
        </div>

          <div class="user">
             <div class="perfil">
                <button id="perfil-btn">
                    <img src="perfil/perfil.png" alt="Perfil">
                </button>
            </div>
            <div id="options" class="hidden">
                 <a href="login.html">
                    <button class="action-btn">Criar Conta</button>
                 </a>
                <a href="entrar.html">
                     <button class="action-btn">Entrar na Conta</button>
                </a>
             </div>
            <div class="menu">
                <a href="#">Cesta</a>
                <a href="#">Minha Conta</a>
                <a href="#">Ajuda</a>
                <a href="#">Sobre</a>
            </div>

                        <img id="toggleButton" src="icons/next.png" alt="Abrir/Fechar Barra" />

        </div>
    </header>

    <main> 
        <section class="carousel" aria-label="Gallery">
             <ol class="carousel__viewport">
                <li id="carousel__slide1" class="carousel__slide">
                    <div class="carousel__snapper">
                        <img src="img/coisa.jpeg" alt="Banner">
                    </div>
                </li>
                <li id="carousel__slide2" class="carousel__slide">
                    <div class="carousel__snapper">
                        <img src="img/coisa2.jpg" alt="Descrição da imagem 2">
                    </div>
                </li>
                <li id="carousel__slide3" class="carousel__slide">
                    <div class="carousel__snapper">
                        <img src="img/coisa3.jpg" alt="Descrição da imagem 3">
                    </div>
                </li>
            </ol>
        </section>

        <div class="list-card">
<?php foreach ($icon_cards as $card): ?>
            <div class="card-container">
                <img src="<?= $card['img_src'] ?>" alt="<?= $card['img_alt'] ?>">
                <h3><?= $card['title'] ?></h3>
                <button>Mostrar</button>
        </div>
<?php endforeach; ?>
        </div>

        <section class="products">
            <h2>Mais indicados para você</h2>
            <div class="product-list">
<?php if (empty($produtos)): ?>
    <p>Nenhum produto encontrado no momento. Verifique a conexão com o banco de dados e se a tabela 'produtos' está preenchida.</p>
<?php else: ?>
    <?php foreach ($produtos as $produto): ?>
                <div class="product-card">
                    <img src="<?= $produto['img_src'] ?>" alt="<?= $produto['img_alt'] ?>">
                    <h3><?= $produto['name'] ?></h3>
                    <p><?= $produto['price'] ?></p>
                   <button type="button"><a href="<?= $produto['link'] ?>" class="buttin" alt="<?= $produto['name'] ?>">
                        Comprar
                    </a></button>
                 </div>
    <?php endforeach; ?>
<?php endif; ?>
             </div>
        </section>
    </main>

    <footer class="footer">
        <p>Desenvolvido por Felipe Dias, Pedro Neto, Endryo Matos e Felipe Madson © 2025 AgroTech</p>
    </footer>
    <script src="javinha.js"></script>
</body>
</html>