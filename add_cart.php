<?php
session_start();
include 'functions.php';

if (!isset($_SESSION['login'])) {
    echo json_encode([
        'status' => 'not_login'
    ]);
    exit;
}

$product_id = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

if ($product_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID produk tidak valid'
    ]);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += 1;
} else {
    $_SESSION['cart'][$product_id] = 1;
}

$total_items = array_sum($_SESSION['cart']);

echo json_encode([
    'status' => 'success',
    'total' => $total_items
]);
exit;
