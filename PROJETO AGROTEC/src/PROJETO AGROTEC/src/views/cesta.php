<?php
session_start();

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

// Lógica de ações (adicionar, remover, alterar quantidade)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? null;
    $id   = $_POST['id'] ?? null;

    if ($acao === 'adicionar') {
        // Implemente a busca no BD aqui se necessário. Para este exemplo, apenas adiciona o que foi postado.
        $novoItem = [
            'id'          => $id,
            'nome'        => $_POST['nome'] ?? 'Produto', 
            'preco'       => floatval($_POST['preco'] ?? 0),
            'vendedor'    => $_POST['vendedor'] ?? 'AgroTech',
            'imagem'      => $_POST['imagem'] ?? '../public/assets/img/default.png',
            'quantidade'  => 1
        ];

        $existe = false;
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['id'] == $id) {
                $item['quantidade']++;
                $existe = true;
                break;
            }
        }
        unset($item);
        if (!$existe) {
            $_SESSION['carrinho'][] = $novoItem;
        }

    } elseif ($acao === 'remover') {
        foreach ($_SESSION['carrinho'] as $index => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['carrinho'][$index]);
            }
        }
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);

    } elseif ($acao === 'mais' || $acao === 'menos') {
        foreach ($_SESSION['carrinho'] as &$item) {
            if ($item['id'] == $id) {
                if ($acao === 'mais') {
                    $item['quantidade']++;
                } elseif ($acao === 'menos' && $item['quantidade'] > 1) {
                    $item['quantidade']--;
                }
            }
        }
        unset($item);
    }
}

// Função para calcular subtotal 
function calcularSubtotal($carrinho) {
    $subtotal = 0;
    foreach ($carrinho as $item) {
        $subtotal += $item['preco'] * $item['quantidade'];
    }
    return $subtotal;
}

$carrinho = $_SESSION['carrinho'];
$subtotal = calcularSubtotal($carrinho);
$frete = 0.00;
$descontos = 0.00;
$total = $subtotal + $frete - $descontos;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AgroTech - Carrinho</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/assets/css/carrot.css">
    <link rel="stylesheet" href="../public/assets/css/cesta.css">
    
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">
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
                <a href="cesta.php" class="nav-link">
                    Cesta <span id="cart-badge" class="badge-count"><?php echo count($carrinho); ?></span>
                </a>
                <a href="ofertas.html" class="nav-link">Sobre</a>
                <a href="vendedores.html" class="nav-link">Vender</a>
                <a href="ajuda.html" class="nav-link">Ajuda</a>
            </nav>
        </div>
    </header>

    <main class="main-content" style="flex-grow: 1;">
        <section class="cart card">
            <div class="cart-header">
                <h2 class="cart-title">Seu carrinho</h2>
                <div class="add-product">
                    <a href="index.php" class="btn-primary">Adicionar mais produtos</a>
                </div>
            </div>

            <div class="cart-items" id="cart-items">
                <?php if (empty($carrinho)): ?>
                    <p>Seu carrinho está vazio.</p>
                <?php else: ?>
                    <?php foreach ($carrinho as $item): ?>
                    <article class="cart-item">
                        <div class="thumb"><img src="<?php echo htmlspecialchars($item['imagem']); ?>" alt="<?php echo htmlspecialchars($item['nome']); ?>"></div>
                        <div class="item-info">
                            <h3 class="item-title"><?php echo htmlspecialchars($item['nome']); ?></h3>
                            <p class="item-meta">Vendido por <?php echo htmlspecialchars($item['vendedor']); ?></p>
                            <form method="post">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <button type="submit" name="acao" value="remover" class="item-remove">Remover</button>
                            </form>
                        </div>
                        <div class="item-actions">
                            <div class="qty">
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <button type="submit" name="acao" value="menos" class="btn-qty">−</button>
                                    <input type="number" value="<?php echo htmlspecialchars($item['quantidade']); ?>" min="1" readonly>
                                    <button type="submit" name="acao" value="mais" class="btn-qty">+</button>
                                </form>
                            </div>
                            <div class="price">R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <aside class="summary card">
            <h2>Resumo</h2>
            <div class="row"><span>Subtotal</span><span id="subtotal">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span></div>
            <div class="row"><span>Frete</span><span>R$ <?php echo number_format($frete, 2, ',', '.'); ?></span></div>
            <div class="row"><span>Descontos</span><span>− R$ <?php echo number_format($descontos, 2, ',', '.'); ?></span></div>
            <div class="total"><span>Total</span><span id="total">R$ <?php echo number_format($total, 2, ',', '.'); ?></span></div>

            <div class="checkout">
                <button class="btn-primary">Finalizar compra</button>
                <button class="btn-secondary" onclick="abrirPopup()">Continuar comprando</button>
            </div>
        </aside>
    </main>

    <footer class="footer">
        <a href="index.php" class="btn-back-footer">← Voltar</a>
    </footer>
    
    <div id="popup" class="popup-overlay">
        <div class="popup-box">
            <h3>Itens no carrinho</h3>
            <p>Você já adicionou produtos ao carrinho. Deseja voltar para a página inicial?</p>
            <div class="popup-actions">
                <button onclick="window.location.href='index.php'" class="btn-primary">Sim, voltar</button>
                <button onclick="fecharPopup()" class="btn-secondary">Continuar aqui</button>
            </div>
        </div>
    </div>

    <script src="../public/assets/js/cesta.js"></script>
    <script>
        // Funções JavaScript (Mantenha as funções básicas aqui ou no cesta.js)
        function abrirPopup() {
            document.getElementById('popup').style.display = 'flex';
        }
        function fecharPopup() {
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>
</html>