<?php
ob_start();
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

$user_id = (int) ($_SESSION['id'] ?? 0);

$produk_list = [];
$total_harga = 0;

$ids = implode(",", array_map('intval', array_keys($cart)));
$q = mysqli_query($conn, "SELECT * FROM produk WHERE id IN ($ids)");

while ($row = mysqli_fetch_assoc($q)) {
    $row['qty'] = (int) $cart[$row['id']];
    $produk_list[] = $row;
    $total_harga += $row['harga'] * $row['qty'];
}

$order_code = "ORD-" . rand(100, 1999);

$query = "INSERT INTO orders (order_code, user_id, outlet, metode, total_harga, tanggal)
          VALUES ('" . mysqli_real_escape_string($conn, $order_code) . "', $user_id, '" . mysqli_real_escape_string($conn, $outlet) . "', '" . mysqli_real_escape_string($conn, $method) . "', $total_harga, NOW())";

if (!mysqli_query($conn, $query)) {
    die('SQL ERROR: ' . mysqli_error($conn));
}

$last_order_id = mysqli_insert_id($conn);
$_SESSION['last_order_id'] = $last_order_id;

$stmt_values = [];
foreach ($produk_list as $p) {
    $product_id = (int) $p['id'];
    $nama = mysqli_real_escape_string($conn, $p['nama']);
    $qty = (int) $p['qty'];
    $harga = (int) $p['harga'];

    $query_det = "
        INSERT INTO order_detail (order_id, product_id, nama, qty, harga)
        VALUES ($last_order_id, $product_id, '$nama', $qty, $harga)
    ";

    if (!mysqli_query($conn, $query_det)) {
        die('SQL ERROR (detail): ' . mysqli_error($conn));
    }
}

$_SESSION['checkout_orderid'] = $order_code;
$_SESSION['checkout_outlet'] = $outlet;
$_SESSION['checkout_method'] = $method;
$_SESSION['checkout_produk'] = $produk_list;
$_SESSION['checkout_total'] = $total_harga;
$_SESSION['checkout_date'] = date("Y-m-d H:i:s");

unset($_SESSION['cart']);

if ($method === "qris") {
    header("Location: qr.php");
    exit;
}

header("Location: struk.php?order=$last_order_id");
exit;
ob_end_flush();