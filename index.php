<?php
session_start();
require 'functions.php';

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
      $_SESSION["id"] = $row["id"];
      $_SESSION["username"] = $row["username"];
      $_SESSION["email"] = $row["email"];
      header("Location: index.php");
      exit;
    }
  }
  $error = true;
}

//ulasan
$ulasan = mysqli_query($conn, "SELECT * FROM ulasan");

if (isset($_POST["submit"])) {
  $nama = htmlspecialchars($_POST["username"]);
  $email = htmlspecialchars($_POST["email"]);
  $isiUlasan = htmlspecialchars($_POST["ulasan"]);

  $query = "INSERT INTO ulasan (username, email, ulasan, status) 
              VALUES ('$nama', '$email', '$isiUlasan', 'unread')";
  mysqli_query($conn, $query);

  header("Location: " . $_SERVER['PHP_SELF'] . "?ulasan=success");
  exit;
}

?>

<?php if (isset($_GET['ulasan']) && $_GET['ulasan'] == 'success'): ?>
  <script>
    alert('Ulasan berhasil dikirim!');

    // Hapus ?ulasan=success dari URL tanpa reload
    if (window.history.replaceState) {
      const cleanUrl = window.location.href.split("?")[0];
      window.history.replaceState(null, null, cleanUrl);
    }
  </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bakso Masroy</title>
  <link rel="stylesheet" href="css/style.css" />
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
      <a href="#beranda">Beranda</a>
      <a href="#tentang">Tentang</a>
      <a href="#produk">Produk</a>
      <a href="#ulasan">Ulasan</a>
    </div>

    <div class="navbar-extra">
      <a href="cart.php" id="cart" class="cart">
        <i class="fa-solid fa-cart-shopping"></i>
      </a>

      <a href="#" id="language" class="language">
        <i class="fa-solid fa-language"></i>
      </a>

      <div class="language-dropdown" id="languageDropdown">
        <a href="#ind"> IND </a>
        <a href="#usa"> USA </a>
      </div>

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
            <a href="term-of-services.html">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>
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
            <a href="term-of-services.html">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>
            Bakso MasRoy.
          </p>
        </div>
      </form>
    </div>
  </div>

  <section class="beranda" id="beranda">
    <div class="content">
      <div class="whatis">
        <h2>Bakso Masroy</h2>
        <p>
          Bakso Mas Roy hadir sebagai ikon kuliner khas Surabaya yang
          mengusung cita rasa autentik, bahan berkualitas, dan pelayanan
          ramah. Kami ingin menghadirkan pengalaman makan bakso yang lebih
          dari sekadar lezat—sebuah momen yang bisa menyatukan orang dari
          berbagai latar belakang. Melalui setiap sajian, kami juga membawa
          misi untuk membuka peluang kerja dan memperkenalkan kekayaan kuliner
          Indonesia ke seluruh penjuru negeri. Dari Surabaya untuk Indonesia,
          nikmati bakso yang dibuat dengan sepenuh hati.
        </p>
        <div class="container-cta">
          <div class="offon-cta">
            <button class="btn btn-left active" onclick="toggle(this, 'online')">
              <span>Online</span>
            </button>
            <button class="btn btn-right" onclick="toggle(this, 'offline')">
              <span>Offline</span>
            </button>
          </div>
        </div>
      </div>
      <div class="photo">
        <img src="css/properties/baksoamsroy.jpg" alt="Bakso MasRoy" />
      </div>
    </div>
  </section>

  <audio id="backgroundAudio" loop preload="auto">
    <source
      src="css/properties/Pusma Shakira feat Royhan Ni Amillah - EGO WONG TUO (Official Music Video)  Kudu Iso Kuat Balungane - Pusma Shakira.mp3"
      type="audio/mpeg" />
  </audio>

  <div class="audio-control">
    <div class="volume-panel" id="volumePanel">
      <input type="range" class="volume-slider" id="volumeSlider" min="0" max="100" value="50" orient="vertical" />
      <div class="volume-text" id="volumeText">50%</div>
    </div>
    <button class="mute-button" id="muteButton">🔊</button>
  </div>

  <section class="tentang" id="tentang">
    <h2>Tentang Bakso Mas Roy</h2>
    <p>
      Bakso Mas Roy adalah kuliner populer di Surabaya yang terkenal dengan
      bakso padat daging tanpa tepung dan kuah gurih khas. Pelanggan bebas
      memilih kombinasi bakso, tetelan iga, dan gorengan sesuai selera. Konsep
      tanpa paket membuat pengalaman makan jadi fleksibel. Popularitasnya
      meningkat berkat keikutsertaan di berbagai event kuliner dan liputan
      media seperti Jawa Pos, menjadikannya favorit pecinta bakso Surabaya.
    </p>

    <div class="temtang-section">
      <div class="center-line" id="centerLine"></div>

      <div class="line-item right">
        <div class="image">
          <img src="css/properties/outletmer.png" alt="Bakso">
        </div>
        <div class="cobox right">
          <div class="tittle">Awal Popularitas </div>
          <div class="year">2023</div>
          <div class="paragraf">
            Bakso Mas Roy mulai dikenal luas lewat konten viral di TikTok yang menarik dan interaktif. Cabang pertama
            diduga berada di Merr, Surabaya Barat, lalu berkembang ke Dukuh Kupang Surabaya dan Sidoarjo.
          </div>
        </div>
        <div class="center-dot"></div>
      </div>

      <div class="line-item left">
        <div class="image">
          <img src="css/properties/outletaloha.webp" alt="Bakso">
        </div>
        <div class="cobox left">
          <div class="tittle">Ekspansi & Digitalisasi </div>
          <div class="year">2024</div>
          <div class="paragraf">
            Bakso Mas Roy membuka cabang baru di Sawotratap Aloha, Sidoarjo pada September 2024 sebagai bukti
            pertumbuhan bisnis. Pada awal 2024, strategi pemasaran digital dan pengembangan aplikasi penjualan online
            mulai ada untuk mendukung layanan modern.
          </div>
        </div>
        <div class="center-dot"></div>
      </div>
      <div class="line-item right">
        <div class="image">
          <img src="css/properties/outletdupang.png" alt="Bakso">
        </div>
        <div class="cobox right">
          <div class="tittle">Puncak Kepopuleran </div>
          <div class="year">2025</div>
          <div class="paragraf">
            Bakso Mas Roy mendapat sorotan dari media besar seperti Jawa Pos sebagai kuliner yang paling diburu. Dikenal
            dengan rasa otentik, bakso jumbo, dan kuah gurih khas, Bakso Mas Roy terus menarik pelanggan lewat inovasi
            varian produk yang menjaga daya tariknya
          </div>
        </div>
        <div class="center-dot"></div>
      </div>

    </div>
    <p>
      Bakso Mas Roy adalah kuliner populer di Surabaya yang terkenal dengan
      bakso padat daging tanpa tepung dan kuah gurih khas. Pelanggan bebas
      memilih kombinasi bakso, tetelan iga, dan gorengan sesuai selera. Konsep
      tanpa paket membuat pengalaman makan jadi fleksibel. Popularitasnya
      meningkat berkat keikutsertaan di berbagai event kuliner dan liputan
      media seperti Jawa Pos, menjadikannya favorit pecinta bakso Surabaya.
    </p>

  </section>

  <section class="produk-section" id="produk">
    <h2>Produk Bakso Mas Roy</h2>
    <div class="pembungkusluar">

      <?php
      $result = mysqli_query($conn, "SELECT * FROM produk");
      while ($row = mysqli_fetch_assoc($result)):
      ?>
        <div class="produk-item">
          <div class="container">
            <div class="foto-produk">
              <div class="shimmer"></div>
              <img src="<?= $row['image'] ?> " alt="<?= $row['nama'] ?>" />
            </div>
            <div class="judul">
              <h4>
                <?= $row['kategori'] ?>
              </h4>
            </div>
            <div class="nama">
              <h3>
                <?= $row['nama'] ?>
              </h3>
            </div>
            <div class="deskripsi">
              <p>
                <?= $row['deskripsi'] ?>
              </p>
            </div>
            <div class="hargapesan">
              <div class="harga-produk">
                <h3>Rp
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
    <div class="lihat-lainnya">
      <a href="listmenu.php">
        <button class="btn-lain">
          Lihat Lainnya
        </button>
      </a>
    </div>
  </section>

  <section class="lokasi-outlet" id="lokasi-outlet">
    <h2>Lokasi Outlet</h2>
    <div class="container">
      <div class="map" style="width:850px; height:450px; overflow:hidden;">
        <iframe src="https://www.google.com/maps/d/u/0/embed?mid=1MhFemuzFrjyVtKJKO8R3VcViOnZDxaI&ehbc=2E312F&noprof=1"
          style="width:1000px; height:700px; margin-top:-60px; border:0;"></iframe>
      </div>
      <div class="container-info-lokasi">
        <div class="info-lokasi active"
          data-map="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.241!2d112.7509!3d-7.2574!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMTUnMjYuNiJTIDExMsKwNDUnMDMuMiJF!5e0!3m2!1sen!2sid!4v1234567890">
          <h3>BAKSO MAS ROY -<br> Cabang Merr</h3>
          <div class="ALAMAT">
            <h5>Alamat</h5>
            <h4>
              Jl. Dr. Ir. H. Soekarno, Klampis Ngasem, Kec. Sukolilo, Surabaya,
              Jawa Timur 60117
          </div>
          </h4>
          <h5>Jam Operasional</h5>
          <h4>Senin - Minggu | 11 : 00 AM - 23 : 00 PM</h4>
          <h5>No Telp</h5>
          <h4>+62 856-0489-7822</h4>
          <div class="cta-open-google-map">
            <button class="btn-goonel">
              <a href="https://maps.app.goo.gl/x6wf3K8zpSjZVBRu8" target="_blank"> <i
                  class="fa-solid fa-location-pin"></i> Open In Google Maps</a>
            </button>
          </div>
        </div>
        <div class="info-lokasi"
          data-map="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.6!2d112.7194!3d-7.2478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMTQnNTIuMSJTIDExMsKwNDMnMDkuOCJF!5e0!3m2!1sen!2sid!4v1234567891">
          <h3>BAKSO MAS ROY -<br> Cabang Dukuh Kupang</h3>
          <h4>
            Jl. Raya Dukuh Kupang No.149, RT.6/RW.8, Pakis, Kec. Sawahan,
            Surabaya, Jawa Timur 60189
          </h4>
          <h4>Jam Operasional : Senin - Minggu | 11 : 00 AM - 23 : 00 PM</h4>
          <h4>No.Telp : +62 878-4114-6205</h4>
          <div class="cta-open-in-google-map">
            <button class="btn-goonel">
              <a href="https://maps.app.goo.gl/6Whd1UxzRAMgRCUM9" target="_blank"><i
                  class="fa-solid fa-location-pin"></i> Open In Google Maps</a>
            </button>
          </div>
        </div>
        <div class="info-lokasi"
          data-map="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.8!2d112.7285!3d-7.3421!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMjAnMzEuNiJTIDExMsKwNDMnNDIuNiJF!5e0!3m2!1sen!2sid!4v1234567892">
          <h3>BAKSO MAS ROY -<br> Cabang Aloha</h3>
          <h4>
            Dusun Pager, Sawotratap, Kec. Gedangan, Kabupaten Sidoarjo, Jawa
            Timur
          </h4>
          <h4>Jam Operasional : Senin - Minggu | 11 : 00 AM - 23 : 00 PM</h4>
          <h4>No.Telp : +62 895-2491-3184</h4>
          <div class="cta-open-in-google-map">
            <button class="btn-goonel">
              <a href="https://maps.app.goo.gl/WLgunXKdJyxB1mdw9" target="_blank"><i
                  class="fa-solid fa-location-pin"></i> Open In Google Maps</a>
            </button>
          </div>
        </div>
        <div class="button-container">
          <div class="prev-button">
            <button id="prevOutlet">
              <i class="fa-solid fa-arrow-left"></i>
            </button>
          </div>
          <div class="outlet-indicator">
            <span class="indicator-dot active" data-index="0"></span>
            <span class="indicator-dot" data-index="1"></span>
            <span class="indicator-dot" data-index="2"></span>
          </div>
          <div class="next-button ">
            <button id="nextOutlet">
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="ulasan" id="ulasan">
    <div class="form-ulasan">
      <h2>Ulasan</h2>
      <form action="index.php" method="post">
        <input type="text" placeholder="Nama" name="username" required />
        <input type="email" placeholder="E-mail" name="email" required />
        <textarea cols="30" rows="10" placeholder="Tulis Ulasan Anda" name="ulasan" required></textarea>
        <button type="submit" name="submit">Kirim</button>
      </form>
    </div>

    <div class="navigasi-info-dan-medsos">
      <div class="navigasi">
        <h3>Bakso Mas Roy</h3>
        <div class="navigasi-link">
          <a href="#">Beranda</a>
          <a href="#tentang">Tentang</a>
          <a href="#produk">Produk</a>
          <a href="#ulasan">Ulasan</a>
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
        <hr class="betsos" />
        <h2>Media Sosial :</h2>
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
  </section>

  <footer>
    <p>© 2025 Bakso Mas Roy. All rights reserved.</p>
    <a href="privacy-policy.php" style="text-decoration: none; color: #000">Privacy Policy</a>
    <a href="term-of-services.php" style="text-decoration: none; color: #000">Terms Of Services</a>
  </footer>

  <script src="js/script.js"></script>
</body>

</html>