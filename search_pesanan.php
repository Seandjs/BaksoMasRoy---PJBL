<?php
require 'functions.php';

$keyword = $_GET['keyword'] ?? '';

$q = mysqli_query($conn, "
    SELECT 
        orders.id,
        orders.order_code,
        orders.tanggal,
        orders.outlet,
        orders.total_harga,
        user.username AS nama_user
    FROM orders
    LEFT JOIN user ON orders.user_id = user.id
    WHERE 
        orders.order_code LIKE '%$keyword%' OR
        user.username LIKE '%$keyword%' OR
        orders.outlet LIKE '%$keyword%'
    ORDER BY orders.tanggal DESC
");

function getItems($conn, $id)
{
    $x = mysqli_query($conn, "SELECT nama, qty FROM order_detail WHERE order_id=$id");
    $items = [];
    while ($r = mysqli_fetch_assoc($x)) {
        $items[] = $r['nama'] . " x" . $r['qty'];
    }
    return implode(", ", $items);
}

if (mysqli_num_rows($q) == 0) {
    echo "<p style='padding:10px'>Pesanan tidak ditemukan…</p>";
    exit;
}

while ($p = mysqli_fetch_assoc($q)) {
    echo "
    <div class='pesanan-card'>
        <div class='pesanan-header-card'>
            <span class='pesanan-id'>#{$p['order_code']}</span>
        </div>

        <div class='pesanan-body'>
            <div class='pesanan-info-item'>
                <label>Nama Pelanggan</label>
                <span>{$p['nama_user']}</span>
            </div>

            <div class='pesanan-info-item'>
                <label>Pesanan</label>
                <span>" . getItems($conn, $p['id']) . "</span>
            </div>

            <div class='pesanan-info-item'>
                <label>Outlet</label>
                <span>{$p['outlet']}</span>
            </div>

            <div class='pesanan-info-item'>
                <label>Tanggal Pesan</label>
                <span>" . date("d M Y, H:i", strtotime($p['tanggal'])) . "</span>
            </div>

            <div class='pesanan-info-item'>
                <label>Total Pembayaran</label>
                <span class='pesanan-total'>Rp " . number_format($p['total_harga'], 0, ',', '.') . "</span>
            </div>
        </div>
    </div>
    ";
}
