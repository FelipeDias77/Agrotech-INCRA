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
if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
    exit;
}

// Inicializa carrinho em sessão
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Incrementa quantidade se já existir
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

echo json_encode(['success' => true, 'cart' => $_SESSION['cart']]);

?>
