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
          <div class='shimmer'></div>
          <img src='{$p['image']}' alt='{$p['nama']}'>
        </div>

        <div class='judul'>
          <h4>" . ucfirst($p['kategori']) . "</h4>
        </div>

        <div class='nama'>
          <h3>{$p['nama']}</h3>
        </div>

        <div class='deskripsi'>
          <p>{$p['deskripsi']}</p>
        </div>

        <div class='hargapesan'>
          <div class='harga-produk'>
            <h3>Rp " . number_format($p['harga'], 0, ',', '.') . "</h3>
          </div>

          <div class='cta-produk'>
            <a href='menubaksomasroy.php?id={$p['id']}'>Pesan Sekarang</a>
          </div>
        </div>

      </div>
    </div>
    ";
}