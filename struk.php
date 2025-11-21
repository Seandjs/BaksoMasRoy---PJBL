<?php
session_start();
include 'functions.php';
date_default_timezone_set('Asia/Jakarta');

if (isset($_GET['order'])) {

    $oid = $_GET['order'];
    $q = mysqli_query($conn, "SELECT * FROM orders WHERE id = $oid");
    $order = mysqli_fetch_assoc($q);

    if (!$order) {
        die("Order tidak ditemukan.");
    }

    $orderid = $order['order_code'];
    $tanggal = $order['tanggal'];
    $total = $order['total_harga'];
    $outlet = $order['outlet'];
    $method = $order['metode'];

    $produk = [];

} else {

    if (!isset($_SESSION['checkout_orderid'])) {
        header("Location: cart.php");
        exit;
    }

    $orderid = $_SESSION['checkout_orderid'];
    $tanggal = $_SESSION['checkout_date'];
    $total = $_SESSION['checkout_total'];
    $outlet = $_SESSION['checkout_outlet'];
    $method = $_SESSION['checkout_method'];
    $produk = $_SESSION['checkout_produk'];

    $total = 0;
    foreach ($produk as $p) {
        $total += $p['harga'] * $p['qty'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bakso Campur - Receipt</title>
    <link rel="stylesheet" href="css/summary.css" />
    <link rel="icon" type="image/png" href="css/properties/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<body>
    <nav>
        <div class="logo">
            <a href="">
                <img src="css/properties/logo.png" alt="Logo Bakso MasRoy" />
            </a>
        </div>

        <div class="navbar-nav" id="navbarNav">
            <a href="index.php#beranda">Beranda</a>
            <a href="index.php#tentang">Tentang</a>
            <a href="index.php#produk">Produk</a>
            <a href="index.php#ulasan">Ulasan</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="cart" class="cart">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            <a href="#" id="user" class="user">
                <i class="fa-solid fa-user"></i>
            </a>

            <div class="user-dropdown" id="userDropdown">
                <a href="#login">
                    <i class="fa-solid fa-right-to-bracket"></i> Log In
                </a>
                <a href="#signup"> <i class="fa-solid fa-user-plus"></i> Sign Up </a>
            </div>

            <a href="#" id="logout" class="logout">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>

            <a href="#" id="menu" class="menu">
                <i class="fa-solid fa-bars"></i>
            </a>
        </div>
    </nav>

    <section id="receipt" class="receipt">
        <div class="main-header">
            <div class="main-title">
                <h1>Ringkasan Belanja</h1>
            </div>
        </div>
        <div class="receipt-container">
            <div class="receipt-header">
                <div class="receipt-title">
                    <h1>Bakso Mas Roy</h1>
                </div>
                <div class="outlet">
                    <h2><?= $outlet ?></h2>
                </div>
            </div>

            <div class="receipt-info">
                <div class="info-item">
                    <span class="info-label"><?= $orderid ?></span>
                </div>
                <div class="info-item">
                    <span class="info-value"><?= $tanggal ?></span>
                </div>
            </div>

            <div class="receipt-body">
                <?php foreach ($produk as $p): ?>
                    <div class="receipt-item">
                        <span class="item-name"><?= $p['nama'] ?></span>
                        <span class="item-qty"><?= $p['qty'] ?>x</span>
                        <span class="item-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="receipt-footer">
                <div class="footer-info">
                    <p>Total QTY : <?= array_sum(array_column($produk, 'qty')); ?></p>
                    <p>Metode Pembayaran : <?= strtoupper($method) ?></p>
                </div>
                <div class="total-section">
                    <div class="subtotal">
                        <span>Sub Total</span>
                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="total">
                        <span>Total</span>
                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                </div>
                <a href="index.php" class="btn-back">Kembali ke Halaman Utama</a>
                <!-- <button class="btn-back">Kembali ke Halaman utama</button> -->
            </div>
        </div>
    </section>

    <footer>
        <div class="navigasi-info-dan-medsos">
            <div class="navigasi">
                <h3>Bakso Mas Roy</h3>
                <div class="navigasi-link">
                    <a href="index.php#beranda">Beranda</a>
                    <a href="index.php#tentang">Tentang</a>
                    <a href="index.php#produk">Produk</a>
                    <a href="index.php#ulasan">Ulasan</a>
                </div>
            </div>
            <div class="info">
                <h3>Cabang</h3>
                <div class="info-link">
                    <a href="#">Merr - Surabaya</a>
                    <a href="#">Dukuh Kupang - Surabaya</a>
                    <a href="#">Sawotratap Aloha - Sidoarjo</a>
                </div>
            </div>
            <div class="medsos">
                <h3>Media Sosial :</h3>
                <div class="medsos-link">
                    <ul>
                        <li>
                            <a href="https://www.instagram.com/baksomasroy/"><i class="fab fa-instagram icon"></i></a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@baksomasroy?lang=en"><i
                                    class="fa-brands fa-tiktok icon"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="betmut" />
        <div class="copyright">
            <p>Â© 2025 Bakso Mas Roy. All rights reserved.</p>
            <p>Privacy Policy</p>
            <p>Terms Of Services</p>
        </div>
    </footer>
</body>
<script>
    const userButton = document.getElementById("user");
    const userDropdown = document.getElementById("userDropdown");

    if (userButton && userDropdown) {
        userButton.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            userDropdown.classList.toggle("active");
        });

        document.addEventListener("click", function (e) {
            if (
                !userButton.contains(e.target) &&
                !userDropdown.contains(e.target)
            ) {
                userDropdown.classList.remove("active");
            }
        });

        userDropdown.addEventListener("click", function (e) {
            e.stopPropagation();
        });
    }
</script>

</html>