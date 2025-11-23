<?php
require 'functions.php';

$keyword = $_GET['keyword'] ?? '';

if ($keyword == '') {
    echo "";
    exit;
}

$query = "SELECT * FROM produk 
          WHERE nama LIKE '%$keyword%' 
          OR kategori LIKE '%$keyword%'
          OR deskripsi LIKE '%$keyword%'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p style='text-align:center; margin-top:20px;'>Produk tidak ditemukan...</p>";
    exit;
}

while ($p = mysqli_fetch_assoc($result)) {
    echo "
    <div class='produk-item'>
      <div class='container'>
        <div class='foto-produk'>
          <img src='{$p['image']}' alt='{$p['nama']}'>
        </div>

        <h4>{$p['kategori']}</h4>
        <h3>{$p['nama']}</h3>
        <p>{$p['deskripsi']}</p>

        <div class='harga'>
          Rp " . number_format($p['harga'], 0, ',', '.') . "
        </div>

        <a href='menubaksomasroy.php?id={$p['id']}'>Pesan Sekarang</a>
      </div>
    </div>
  ";
}
?>