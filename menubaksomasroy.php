<?php
include 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
  header('Location: index.php');
  exit;
}

$query_lainnya = mysqli_query($conn, "SELECT * FROM produk WHERE id != $id LIMIT 3");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $produk['nama'] ?> - Bakso Mas Roy</title>
  <link rel="stylesheet" href="css/stylemenu.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<body>
  <nav>
    <div class="logo">
      <a href="index.php">
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

  <section id="info-menu" class="info-menu">
    <div class="breadcrumb">
      <a href="index.php">Beranda</a>
      <span>›</span>
      <span>Menu</span>
    </div>
    <div class="container-info-menu">
      <div class="info-menu-image">
        <img src="<?= $produk['image'] ?>" alt="<?= $produk['nama'] ?>" />
      </div>
      <div class="info-menu-text">
        <h1><?= $produk['nama'] ?></h1>
        <p><?= $produk['deskripsi'] ?></p>
        <h2>
          Rp
          <?= number_format($produk['harga'], 0, ',', '.') ?>
        </h2>
      </div>
      <div class="cta">
        <div class="cta-pesan-sekarang">
          <a href="checkout.php?id=<?= $produk['id'] ?>">Pesan Sekarang</a>
        </div>
        <div class="cta-tambah-ke-keranjang">
          <a href="add_to_cart.php?id=<?= $produk['id'] ?>">Tambah ke Keranjang</a>
        </div>
      </div>
    </div>
  </section>

  <section id="menu-lainya" class="menu-lainya">
    <h2>Menu Lainnya</h2>
    <div class="pembungkusluar">
      <?php while ($row = mysqli_fetch_assoc($query_lainnya)): ?>
        <div class="produk-item">
          <div class="container">
            <div class="foto-produk">
              <div class="shimmer"></div>
              <img src="<?= $row['image'] ?>" alt="<?= $row['nama'] ?>" />
            </div>
            <div class="judul">
              <h4><?= $row['kategori'] ?></h4>
            </div>
            <div class="nama">
              <h3><?= $row['nama'] ?></h3>
            </div>
            <div class="deskripsi">
              <p><?= $row['deskripsi'] ?></p>
            </div>
            <div class="hargapesan">
              <div class="harga-produk">
                <h3>
                  Rp
                  <?= number_format($row['harga'], 0, ',', '.') ?>
                </h3>
              </div>
              <div class="cta-produk">
                <a href="menubaksomasroy.php?id=<?= $row['id'] ?>">Pesan Sekarang</a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
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
              <a href="https://www.tiktok.com/@baksomasroy?lang=en"><i class="fa-brands fa-tiktok icon"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <hr class="betmut" />
    <div class="copyright">
      <p>© 2025 Bakso Mas Roy. All rights reserved.</p>
      <p>Privacy Policy</p>
      <p>Terms Of Services</p>
    </div>
  </footer>
</body>
<script>
  const produkItems = document.querySelectorAll(".produk-item");

  produkItems.forEach((item) => {
    const container = item.querySelector(".container");
    let isHovering = false;

    item.addEventListener("mouseenter", () => {
      isHovering = true;
    });

    item.addEventListener("mousemove", (e) => {
      if (!isHovering) return;

      const rect = item.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = (y - centerY) / 10;
      const rotateY = (centerX - x) / 10;

      container.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });

    item.addEventListener("mouseleave", () => {
      isHovering = false;
      container.style.transform = "rotateX(0) rotateY(0)";
    });
  });

  const userButton = document.getElementById("user");
  const userDropdown = document.getElementById("userDropdown");

  if (userButton && userDropdown) {
    userButton.addEventListener("click", function(e) {
      e.preventDefault();
      e.stopPropagation();
      userDropdown.classList.toggle("active");
    });

    document.addEventListener("click", function(e) {
      if (
        !userButton.contains(e.target) &&
        !userDropdown.contains(e.target)
      ) {
        userDropdown.classList.remove("active");
      }
    });

    userDropdown.addEventListener("click", function(e) {
      e.stopPropagation();
    });
  }

  // HAMBURGER MENU TOGGLE
  const hamburgerMenu = document.getElementById("menu");
  const navbarNav = document.getElementById("navbarNav");

  if (hamburgerMenu && navbarNav) {
    hamburgerMenu.addEventListener("click", function(e) {
      e.preventDefault();
      e.stopPropagation();
      navbarNav.classList.toggle("active");

      if (navbarNav.classList.contains("active")) {
        document.body.style.overflow = "hidden";
      } else {
        document.body.style.overflow = "auto";
      }
    });

    document.addEventListener("click", function(e) {
      if (
        !hamburgerMenu.contains(e.target) &&
        !navbarNav.contains(e.target)
      ) {
        navbarNav.classList.remove("active");
        document.body.style.overflow = "auto";
      }
    });

    navbarNav.addEventListener("click", function(e) {
      const rect = navbarNav.getBoundingClientRect();
      const clickX = e.clientX - rect.left;
      const clickY = e.clientY - rect.top;

      if (
        clickX > rect.width - 65 &&
        clickX < rect.width - 25 &&
        clickY > 20 &&
        clickY < 60
      ) {
        navbarNav.classList.remove("active");
        document.body.style.overflow = "auto";
      }
    });

    const navLinks = navbarNav.querySelectorAll("a");
    navLinks.forEach((link) => {
      link.addEventListener("click", function() {
        navbarNav.classList.remove("active");
        document.body.style.overflow = "auto";
      });
    });
  }
</script>

</html>