<?php
session_start();
include "functions.php";

if (!isset($_SESSION['login'])) {
    echo json_encode(['status' => 'not_login']);
    exit;
}

$product_id = (int) $_POST['product_id'];
$action = $_POST['action'];

if (!isset($_SESSION['cart'][$product_id])) {
    echo json_encode(['status' => 'error']);
    exit;
}

if ($action === "increase") {
    $_SESSION['cart'][$product_id]++;

} elseif ($action === "decrease") {
    $_SESSION['cart'][$product_id]--;

    if ($_SESSION['cart'][$product_id] <= 0) {
        unset($_SESSION['cart'][$product_id]);
    }
}

$total_qty = array_sum($_SESSION['cart'] ?? []);

$total_harga = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(",", array_keys($_SESSION['cart']));
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE id IN ($ids)");

    while ($row = mysqli_fetch_assoc($query)) {
        $qty = $_SESSION['cart'][$row['id']];
        $total_harga += $row['harga'] * $qty;
    }
}

echo json_encode([
    'status' => 'success',
    'total_qty' => $total_qty,
    'total_harga' => $total_harga,
]);
exit;
