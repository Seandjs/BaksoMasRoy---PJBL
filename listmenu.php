<?php
require 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bakso Campur</title>
  <link rel="stylesheet" href="css/listmenu.css" />
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

  <section id="hero" class="hero">
    <div class="hero-content">
      <div class="hero-desk">
        <div class="hero-header">
          <h2>Menu Bakso Mas Roy</h2>
        </div>
        <div class="hero-p">
          <p>
            Saat ini, pemesanan hanya dapat dilakukan di outlet yang terdaftar. Kami belum menyediakan layanan pemesanan jarak jauh. </p>
        </div>
      </div>
      <div class="container-slide-photos">
        <div class="slide-photos-item">
          <img src="css/properties/outletmer.png" alt="" />
        </div>
      </div>
    </div>
  </section>

  <section id="menu-wrapper" class="menu-wrapper">
    <div class="search-bar">
      <input type="text" placeholder="Cari Makanan..." />
      <button type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </div>
    <div class="makanan">
      <h2>Makanan</h2>
      <div class="pembungkusluar">
        <?php
        $makanan = mysqli_query($conn, "SELECT * FROM produk WHERE kategori='makanan'");
        while ($row = mysqli_fetch_array($makanan)):
        ?>
          <div class="produk-item">
            <div class="container">
              <div class="foto-produk">
                <div class="shimmer"></div>
                <img src="<?= $row['image'] ?>" alt="<?= $row['nama'] ?>" />
              </div>
              <div class="judul">
                <h4><?= ucfirst($row['kategori']) ?></h4>
              </div>
              <div class="nama">
                <h3><?= $row['nama'] ?></h3>
              </div>
              <div class="deskripsi">
                <p>
                  <?= $row['deskripsi'] ?>
                </p>
              </div>
              <div class="hargapesan">
                <div class="harga-produk">
                  <h3>Rp <?= number_format($row['harga'], 0, ',', '.') ?></h3>
                </div>
                <div class="cta-produk">
                  <a href="#pesan">Pesan Sekarang</a>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <div class="minuman">
      <h2>Minuman</h2>
      <div class="pembungkusluar">
        <?php
        $minuman = mysqli_query($conn, "SELECT * FROM produk WHERE kategori='minuman'");
        while ($row = mysqli_fetch_array($minuman)):
        ?>

          <div class="produk-item">
            <div class="container">
              <div class="foto-produk">
                <div class="shimmer"></div>
                <img src="<?= $row['image'] ?>" alt="<?= $row['nama'] ?>" />
              </div>
              <div class="judul">
                <h4><?= ucfirst($row['kategori']) ?></h4>
              </div>
              <div class="nama">
                <h3><?= $row['nama'] ?></h3>
              </div>
              <div class="deskripsi">
                <p>
                  <?= $row['deskripsi'] ?>
                </p>
              </div>
              <div class="hargapesan">
                <div class="harga-produk">
                  <h3>Rp <?= number_format($row['harga'], 0, ',', '.') ?></h3>
                </div>
                <div class="cta-produk">
                  <a href="#pesan">Pesan Sekarang</a>
                </div>
              </div>
            <?php endwhile; ?>
            </div>
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
  const images = [
    "css/properties/outletdupang.png",
    "css/properties/baksoamsroy.jpg",
    "css/properties/outletmer.png",
    "css/properties/baksoamsroy.jpg",
    "css/properties/outletdupang.png",
  ];

  let currentIndex = 0;

  // Fungsi untuk mengganti gambar
  function changeSlideImage() {
    const slideItems = document.querySelectorAll(".slide-photos-item img");

    slideItems.forEach((img, index) => {
      // Tambahkan efek fade out
      img.style.opacity = "0";

      setTimeout(() => {
        // Hitung index gambar berikutnya
        const nextIndex = (currentIndex + index) % images.length;
        img.src = images[nextIndex];

        // Tambahkan efek fade in
        img.style.opacity = "1";
      }, 300);
    });

    // Update index untuk gambar berikutnya
    currentIndex = (currentIndex + 1) % images.length;
  }

  // Inisialisasi transisi CSS untuk efek smooth
  function initializeSlideshow() {
    const slideItems = document.querySelectorAll(".slide-photos-item img");

    slideItems.forEach((img) => {
      img.style.transition = "opacity 0.5s ease-in-out";
    });

    // Ganti gambar setiap 3 detik (3000ms)
    // Ubah angka ini untuk mengatur kecepatan pergantian
    setInterval(changeSlideImage, 3000);
  }

  // Jalankan slideshow ketika halaman sudah dimuat
  window.addEventListener("DOMContentLoaded", initializeSlideshow);

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
</script>

</html>