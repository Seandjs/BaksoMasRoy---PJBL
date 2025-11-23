<?php
session_start();
require 'functions.php';

ini_set('display_errors', 0);
error_reporting(E_ALL);

set_error_handler(function () {
  include 'error.php';
  exit;
});

set_exception_handler(function () {
  include 'error.php';
  exit;
});

register_shutdown_function(function () {
  $error = error_get_last();
  if ($error && $error['type'] === E_ERROR) {
    include 'error.php';
    exit;
  }
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu - Bakso Masroy</title>
  <link rel="stylesheet" href="css/listmenu.css" />
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

      <?php if (isset($_SESSION['login'])): ?>
        <a href="userprofile.php" id="logout" class="logout" style="display: inline;">
          <i class="fa-solid fa-user"></i>
        </a>
      <?php else: ?>
        <a href="#" id="user" class="user">
          <i class="fa-solid fa-user-plus"></i>
        </a>
        <div class="user-dropdown" id="userDropdown">
          <a href="#login"><i class="fa-solid fa-right-to-bracket"></i> Masuk</a>
          <a href="#signup"><i class="fa-solid fa-user-plus"></i> Daftar</a>
        </div>
      <?php endif; ?>

      <a href="#" id="menu" class="menu">
        <i class="fa-solid fa-bars"></i>
      </a>
    </div>
  </nav>

  <div class="popup-overlay" id="popupSignup">
    <div class="popup-content">
      <span class="close-popup" id="closeSignup">&times;</span>
      <h2>Daftar</h2>

      <form action="index.php" method="post">
        <div class="username-wrapper">
          <label for="username-daftar">Nama</label>
          <input type="text" name="username" id="username" placeholder="Contoh: Tedjo" required />
        </div>

        <div class="email-wrapper">
          <label for="email-daftar">Email</label>
          <input type="email" name="email" id="email" placeholder="admin123@gmail.com" required />
        </div>

        <label for="sandi-daftar">Kata Sandi</label>
        <div class="password-wrapper">
          <input type="password" name="password" id="password" placeholder="******" required />
          <button type="button" id="toggle-sandi" class="toggle-password" aria-pressed="false">
            <i class="fa-regular fa-eye"></i>
          </button>
        </div>

        <label for="sandi-daftar">Konfirmasi Kata Sandi</label>
        <div class="password-wrapper">
          <input type="password" name="password2" id="password2" placeholder="******" required />
          <button type="button" id="toggle-sandi" class="toggle-password" aria-pressed="false">
            <i class="fa-regular fa-eye"></i>
          </button>
        </div>

        <button type="submit" name="register" class="btn-daftar">Daftar</button>
        <div class="atau">
          <p>Atau Daftar Dengan</p>
        </div>
        <button type="button" class="btn-google">
          <i class="fa-brands fa-google"></i> Google
        </button>
        <div class="ketentuan">
          <p>
            Dengan mendaftar, saya menyetujui
            <a href="term-of-services.html">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>
            Bakso MasRoy.
          </p>
        </div>
      </form>
    </div>
  </div>

  <div class="popup-overlay" id="popupLogin">
    <div class="popup-content">
      <span class="close-popup" id="closeLogin">&times;</span>
      <h2>Masuk</h2>
      <?php if (isset($error)): ?>
        <p>username / password salah!</p>
      <?php endif; ?>

      <form action="" method="post">
        <div class="username-wrapper">
          <label for="username">Nama</label>
          <input type="text" name="username" id="username" placeholder="Contoh: Paijo" required />
        </div>

        <label for="sandi-daftar">Kata Sandi</label>
        <div class="password-wrapper">
          <input type="password" name="password" id="password" placeholder="******" required
            autocomplete="new-password" />
          <button type="button" id="toggle-sandi" class="toggle-password" aria-pressed="false">
            <i class="fa-regular fa-eye"></i>
          </button>
        </div>

        <button type="submit" name="login" class="btn-daftar">Masuk</button>
        <div class="atau">
          <p>Atau Masuk Dengan</p>
        </div>
        <button type="button" class="btn-google">
          <i class="fa-brands fa-google"></i> Google
        </button>
        <div class="ketentuan">
          <p>
            Dengan mendaftar, saya menyetujui
            <a href="term-of-services.html">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>
            Bakso MasRoy.
          </p>
        </div>
      </form>
    </div>
  </div>

  <section id="hero" class="hero">
    <div class="hero-content">
      <div class="hero-desk">
        <div class="hero-header">
          <h2>Menu Bakso Mas Roy</h2>
        </div>
        <div class="hero-p">
          <p>
            Saat ini, pemesanan hanya dapat dilakukan di outlet yang terdaftar. Kami belum menyediakan layanan pemesanan
            jarak jauh. </p>
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
      <input type="text" id="searchInput" placeholder="Cari Makanan..." autocomplete="off">
      <button type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
    </div>

    <h2 id="searchTitle">Hasil Pencarian</h2>

    <div id="searchResults" class="pembungkusluar">
      <!-- produk tampil disini dongs -->
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
                  <a href="menubaksomasroy.php?id=<?= $row['id'] ?>">Pesan Sekarang</a>
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
                  <a href="menubaksomasroy.php?id=<?= $row['id'] ?>">Pesan Sekarang</a>
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
  /* ===============================
   SLIDESHOW GAMBAR
================================ */
  const images = [
    "css/properties/outletdupang.png",
    "css/properties/baksoamsroy.jpg",
    "css/properties/outletmer.png",
    "css/properties/baksoamsroy.jpg",
    "css/properties/outletdupang.png",
  ];

  let currentIndex = 0;

  function changeSlideImage() {
    const slideItems = document.querySelectorAll(".slide-photos-item img");

    slideItems.forEach((img, index) => {
      img.style.opacity = "0";
      setTimeout(() => {
        const nextIndex = (currentIndex + index) % images.length;
        img.src = images[nextIndex];
        img.style.opacity = "1";
      }, 300);
    });

    currentIndex = (currentIndex + 1) % images.length;
  }

  function initializeSlideshow() {
    const slideItems = document.querySelectorAll(".slide-photos-item img");
    slideItems.forEach((img) => {
      img.style.transition = "opacity 0.5s ease-in-out";
    });
    setInterval(changeSlideImage, 3000);
  }

  window.addEventListener("DOMContentLoaded", initializeSlideshow);


  /* ===============================
     EFEK 3D PRODUK CARD
  ================================ */
  function apply3DEffect() {
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
  }

  apply3DEffect(); // aktifkan untuk produk awal


  /* ===============================
     SEARCH PRODUK + HIDE SECTIONS
  ================================ */
  document.getElementById("searchInput").addEventListener("keyup", function () {
    let keyword = this.value.trim();

    const makanan = document.querySelector(".makanan");
    const minuman = document.querySelector(".minuman");
    const searchTitle = document.getElementById("searchTitle");
    const searchResults = document.getElementById("searchResults");

    if (keyword !== "") {
      makanan.style.display = "none";
      minuman.style.display = "none";
      searchTitle.style.display = "block";
      searchTitle.textContent = "Hasil Pencarian: " + keyword;
    } else {
      makanan.style.display = "block";
      minuman.style.display = "block";
      searchTitle.style.display = "none";
      searchResults.innerHTML = "";
      return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "search.php?keyword=" + keyword, true);

    xhr.onload = function () {
      searchResults.innerHTML = this.responseText;
      apply3DEffect(); // aktifkan 3D untuk hasil search
    };

    xhr.send();
  });


  /* ===============================
     USER DROPDOWN MENU
  ================================ */
  const userButton = document.getElementById("user");
  const userDropdown = document.getElementById("userDropdown");

  if (userButton && userDropdown) {
    userButton.addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      userDropdown.classList.toggle("active");
    });

    document.addEventListener("click", function (e) {
      if (!userButton.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.remove("active");
      }
    });

    userDropdown.addEventListener("click", function (e) {
      e.stopPropagation();
    });
  }


  /* ===============================
     POPUP SIGNUP / LOGIN
  ================================ */
  function handlePopup(openBtn, popup, closeBtn) {
    if (openBtn && popup && closeBtn) {
      openBtn.addEventListener("click", (e) => {
        e.preventDefault();
        popup.style.display = "flex";
      });

      closeBtn.addEventListener("click", () => {
        popup.style.display = "none";
      });

      window.addEventListener("click", (e) => {
        if (e.target === popup) {
          popup.style.display = "none";
        }
      });
    }
  }

  handlePopup(
    document.querySelector('a[href="#signup"]'),
    document.getElementById("popupSignup"),
    document.getElementById("closeSignup")
  );

  handlePopup(
    document.querySelector('a[href="#login"]'),
    document.getElementById("popupLogin"),
    document.getElementById("closeLogin")
  );


  /* ===============================
     TOGGLE PASSWORD
  ================================ */
  function togglePassword(btn, input) {
    if (btn && input) {
      btn.addEventListener("click", () => {
        const isHidden = input.type === "password";
        input.type = isHidden ? "text" : "password";

        btn.setAttribute("aria-pressed", isHidden);
        btn.innerHTML = isHidden ?
          '<i class="fa-regular fa-eye-slash"></i>' :
          '<i class="fa-regular fa-eye"></i>';
      });
    }
  }

  togglePassword(
    document.getElementById("toggle-sandi"),
    document.getElementById("password")
  );

  togglePassword(
    document.getElementById("toggle-sandi-2"),
    document.getElementById("password2")
  );

  togglePassword(
    document.getElementById("toggle-sandi-login"),
    document.getElementById("password-login")
  );
</script>

</html>