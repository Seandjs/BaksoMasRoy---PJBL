<?php
session_start();
include 'functions.php';

if (isset($_POST["register"])) {

  if (registrasi($_POST) > 0) {
    echo " <script>
      alert('user baru berhasil ditambahkan!');
    </script>";
  } else {
    echo mysqli_error($conn);
  }
}

if (isset($_POST["login"])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM user WHERE username ='$username'");

  //cek usn
  if (mysqli_num_rows($result) === 1) {

    //cek pw
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      $_SESSION["login"] = true;
      header("Location: index.php");
      exit;
    }
  }
  $error = true;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

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
  <link rel="icon" type="image/png" href="css/properties/logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>

<body>

  <div class="popup-overlay" id="popupSignup">
    <div class="popup-content">
      <span class="close-popup" id="closeSignup">&times;</span>
      <h2>Daftar</h2>

      <form action="menubaksomasroy.php?id=<?= $produk['id'] ?>" method="post">
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
          <button type="button" id="toggle-sandi-2" class="toggle-password" aria-pressed="false">
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

      <form action="menubaksomasroy.php?id=<?= $produk['id'] ?>" method="post">
        <div class="username-wrapper">
          <label for="username-login">Nama</label>
          <input type="text" name="username" id="username-login" placeholder="Contoh: Paijo" required />
        </div>

        <label for="sandi-login">Kata Sandi</label>
        <div class="password-wrapper">
          <input type="password" name="password" id="password-login" placeholder="******" required
            autocomplete="new-password" />
          <button type="button" id="toggle-sandi-login" class="toggle-password" aria-pressed="false">
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
      <a href="cart.php" id="cart" class="cart">
        <i class="fa-solid fa-cart-shopping"></i>
        <span id="cartCount">0</span>
      </a>

      <?php if (isset($_SESSION['login'])): ?>
        <a href="logout.php" id="logout" class="logout" style="display: inline;">
          <i class="fa-solid fa-right-from-bracket"></i>
        </a>
      <?php else: ?>
        <a href="#" id="user" class="user">
          <i class="fa-solid fa-user"></i>
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

  <section id="info-menu" class="info-menu">
    <div class="breadcrumb">
      <a href="index.php">Beranda</a>
      <span>›</span>
      <a href="listmenu.php">Menu</a>
      <span>›</span>
      <span><?= $produk['nama'] ?></span>
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
          <a href="buy.php?id=<?= $produk['id'] ?>">Pesan Sekarang</a>
        </div>
        <div class="cta-tambah-ke-keranjang">
          <button id="addToCart" data-id="<?= $produk['id'] ?>">Tambah ke Keranjang</button>
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

  document.getElementById('addToCart').addEventListener('click', function() {
    const productId = this.dataset.id;

    fetch('add_cart.php', {
        method: 'POST',
        body: new URLSearchParams({
          product_id: productId
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'not_login') {
          alert("Anda belum login, silakan login terlebih dahulu.");
          window.location.href = 'menubaksomasroy.php?id=<?= $produk['id'] ?>';
        } else if (data.status === 'success') {
          updateCartAnimation(data.total);
        }
      });
  });

  function updateCartAnimation(total) {
    const badge = document.getElementById('cartCount');
    badge.innerText = total;
    badge.classList.add('bounce');

    setTimeout(() => {
      badge.classList.remove('bounce');
    }, 500);
  }

  // POP-UP SIGNUP
  const signupBtn = document.querySelector('a[href="#signup"]');
  const popupSignup = document.getElementById("popupSignup");
  const closeSignup = document.getElementById("closeSignup");

  if (signupBtn && popupSignup && closeSignup) {
    signupBtn.addEventListener("click", (e) => {
      e.preventDefault();
      popupSignup.style.display = "flex";
    });

    closeSignup.addEventListener("click", () => {
      popupSignup.style.display = "none";
    });

    window.addEventListener("click", (e) => {
      if (e.target === popupSignup) {
        popupSignup.style.display = "none";
      }
    });
  }

  // POP-UP LOGIN
  const loginBtn = document.querySelector('a[href="#login"]');
  const popupLogin = document.getElementById("popupLogin");
  const closeLogin = document.getElementById("closeLogin");

  if (loginBtn && popupLogin && closeLogin) {
    loginBtn.addEventListener("click", (e) => {
      e.preventDefault();
      popupLogin.style.display = "flex";
    });

    closeLogin.addEventListener("click", () => {
      popupLogin.style.display = "none";
    });

    window.addEventListener("click", (e) => {
      if (e.target === popupLogin) {
        popupLogin.style.display = "none";
      }
    });
  }

  // TOGGLE PASSWORD VISIBILITY - REGISTER
  const toggleSandi = document.getElementById("toggle-sandi");
  const passwordInput = document.getElementById("password");

  if (toggleSandi && passwordInput) {
    toggleSandi.addEventListener("click", () => {
      const isHidden = passwordInput.type === "password";
      passwordInput.type = isHidden ? "text" : "password";
      toggleSandi.setAttribute("aria-pressed", isHidden);
      toggleSandi.innerHTML = isHidden ?
        '<i class="fa-regular fa-eye-slash"></i>' :
        '<i class="fa-regular fa-eye"></i>';
    });
  }

  // TOGGLE PASSWORD VISIBILITY - CONFIRM PASSWORD
  const toggleSandi2 = document.getElementById("toggle-sandi-2");
  const password2Input = document.getElementById("password2");

  if (toggleSandi2 && password2Input) {
    toggleSandi2.addEventListener("click", () => {
      const isHidden = password2Input.type === "password";
      password2Input.type = isHidden ? "text" : "password";
      toggleSandi2.setAttribute("aria-pressed", isHidden);
      toggleSandi2.innerHTML = isHidden ?
        '<i class="fa-regular fa-eye-slash"></i>' :
        '<i class="fa-regular fa-eye"></i>';
    });
  }

  // TOGGLE PASSWORD VISIBILITY - LOGIN
  const toggleSandiLogin = document.getElementById("toggle-sandi-login");
  const passwordLoginInput = document.getElementById("password-login");

  if (toggleSandiLogin && passwordLoginInput) {
    toggleSandiLogin.addEventListener("click", () => {
      const isHidden = passwordLoginInput.type === "password";
      passwordLoginInput.type = isHidden ? "text" : "password";
      toggleSandiLogin.setAttribute("aria-pressed", isHidden);
      toggleSandiLogin.innerHTML = isHidden ?
        '<i class="fa-regular fa-eye-slash"></i>' :
        '<i class="fa-regular fa-eye"></i>';
    });
  }
</script>

</html>