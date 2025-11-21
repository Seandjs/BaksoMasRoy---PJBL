<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
include 'functions.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$outlet = $_GET['outlet'] ?? '';
$method = $_GET['method'] ?? '';

if ($outlet === '' || $method === '') {
    header("Location: cart.php?error=incomplete");
    exit;
}

$user_id = $_SESSION['id'] ?? 0;

$produk_list = [];
$total_harga = 0;

$ids = implode(",", array_keys($cart));
$q = mysqli_query($conn, "SELECT * FROM produk WHERE id IN ($ids)");

while ($row = mysqli_fetch_assoc($q)) {
    $row['qty'] = $cart[$row['id']];
    $produk_list[] = $row;
    $total_harga += $row['harga'] * $row['qty'];
}

$order_code = "ORD-" . rand(100, 1999);

$_SESSION['last_order_id'] = $last_order_id;
$_SESSION['checkout_orderid'] = $order_code;
$_SESSION['checkout_outlet'] = $outlet;
$_SESSION['checkout_method'] = $method;
$_SESSION['checkout_produk'] = $produk_list;
$_SESSION['checkout_total'] = $total_harga;
$_SESSION['checkout_date'] = date("Y-m-d H:i:s");

$query = "INSERT INTO orders (order_code, user_id, outlet, metode, total_harga)
          VALUES ('$order_code', '$user_id', '$outlet', '$method', '$total_harga')";

$last_order_id = mysqli_insert_id($conn);

if (!mysqli_query($conn, $query)) {
    die('SQL ERROR: ' . mysqli_error($conn));
}

unset($_SESSION['cart']);

if ($method === "qris") {
    header("Location: qr.php");
    exit;
}

header("Location: struk.php");
exit;
