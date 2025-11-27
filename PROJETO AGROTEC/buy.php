<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) {
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

$product_id = isset($data['product_id']) ? (int)$data['product_id'] : 0;
$quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1;
$payment_method = isset($data['payment_method']) ? $data['payment_method'] : 'unknown';

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
    exit;
}

$pdo = getPDO();
try {
    // Busca produto
    $stmt = $pdo->prepare('SELECT id_produtoPK, nome, quantidade, preco FROM produtos WHERE id_produtoPK = ? LIMIT 1');
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    if (!$product) {
        echo json_encode(['success' => false, 'error' => 'Produto não encontrado']);
        exit;
    }

    if ($product['quantidade'] < $quantity) {
        echo json_encode(['success' => false, 'error' => 'Estoque insuficiente']);
        exit;
    }

    // Calcula valor total
    $total = (float)$product['preco'] * $quantity;

    // Inicia transação
    $pdo->beginTransaction();

    // Inserir venda (cliente/ agricultor NULL por enquanto)
    $ins = $pdo->prepare('INSERT INTO vendas (data, valor, formaPagamentos, id_clienteFK, id_agricultorFK) VALUES (CURDATE(), ?, ?, NULL, NULL)');
    $ins->execute([$total, $payment_method]);
    $venda_id = $pdo->lastInsertId();

    // Inserir item de venda
    $insItem = $pdo->prepare('INSERT INTO itens_vendas (id_vendasFK, id_produtoFK, quantidade) VALUES (?, ?, ?)');
    $insItem->execute([$venda_id, $product_id, $quantity]);

    // Atualizar estoque
    $upd = $pdo->prepare('UPDATE produtos SET quantidade = quantidade - ? WHERE id_produtoPK = ?');
    $upd->execute([$quantity, $product_id]);

    $pdo->commit();

    // Limpa carrinho da sessão (opcional)
    if (isset($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    echo json_encode(['success' => true, 'venda_id' => $venda_id]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

?>
