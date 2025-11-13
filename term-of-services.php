<?php
session_start();
require 'functions.php';

// Handle ulasan submission
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
  alert("Ulasan berhasil dikirim!");
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
    <title>Terms of Services</title>
    <link rel="stylesheet" href="css/privpol.css" />
    <link rel="icon" type="image/png" href="css/properties/logo.png" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
  </head>

  <body>
    <nav>
      <div class="logo">
        <a href="index.php">
          <img src="css/properties/logo.png" alt="Logo Bakso MasRoy" />
        </a>
      </div>
      <div class="navbar-nav">
        <a href="index.php#beranda">Kembali ke Beranda</a>
        <a href="index.php#ulasan">Hubungi kami</a>
      </div>
      <div class="navbar-extra">
        <a href="#"><i class="fa-solid fa-bars"></i></a>
      </div>
    </nav>

    <section id="backgon" class="backgon"></section>

    <div class="breadcrumb">
      <a href="index.php">Beranda</a>
      <span>›</span>
      <span>Terms of Services</span>
    </div>

    <section id="isi" class="isi">
      <h2>Ketentuan Layanan (Terms of Services)</h2>
      <p>
        Selamat datang di situs resmi <strong>Bakso Mas Roy</strong>. Dengan
        mengakses dan menggunakan situs ini, Anda menyetujui untuk terikat oleh
        Ketentuan Layanan berikut. Mohon baca dengan seksama sebelum menggunakan
        layanan kami.
      </p>

      <h3>1. Penggunaan Situs</h3>
      <p>
        Anda setuju untuk menggunakan situs ini hanya untuk tujuan yang sah dan
        tidak melanggar hukum, peraturan, atau hak pihak lain.
      </p>

      <h3>2. Informasi Produk dan Layanan</h3>
      <p>
        Kami berupaya memastikan bahwa seluruh informasi yang ditampilkan di
        situs ini akurat dan terbaru. Namun, kami tidak menjamin sepenuhnya
        keakuratan atau kelengkapan informasi tersebut.
      </p>

      <h3>3. Pemesanan dan Pembayaran</h3>
      <p>
        Semua pemesanan tunduk pada ketersediaan stok dan kebijakan harga yang
        berlaku. Harga dapat berubah sewaktu-waktu tanpa pemberitahuan
        sebelumnya.
      </p>

      <h3>4. Hak Kekayaan Intelektual</h3>
      <p>
        Seluruh konten di situs ini (termasuk logo, teks, gambar, dan desain)
        adalah milik <strong>Bakso Mas Roy</strong> dan dilindungi oleh hukum
        hak cipta. Dilarang menyalin, memodifikasi, atau menyebarkan konten
        tanpa izin tertulis.
      </p>

      <h3>5. Pembatasan Tanggung Jawab</h3>
      <p>
        Kami tidak bertanggung jawab atas kerugian langsung maupun tidak
        langsung yang timbul akibat penggunaan atau ketidakmampuan menggunakan
        situs ini.
      </p>

      <h3>6. Perubahan Ketentuan</h3>
      <p>
        Kami berhak mengubah atau memperbarui Ketentuan Layanan ini
        sewaktu-waktu. Perubahan akan berlaku segera setelah diumumkan di
        halaman ini.
      </p>

      <h3>7. Kontak Kami</h3>
      <p>
        Jika Anda memiliki pertanyaan mengenai Ketentuan Layanan ini, silakan
        hubungi kami di <strong>bakso.masroy@gmail.com</strong>.
      </p>

      <p style="margin-top: 1rem; color: #999; font-size: 0.9rem">
        Terakhir diperbarui: 19 Oktober 2025
      </p>
    </section>

    <!-- Bagian ulasan tetap sama -->
    <section class="ulasan" id="ulasan">
      <div class="form-ulasan">
        <h2>Ulasan</h2>
        <form action="index.php" method="post">
          <input type="text" placeholder="Nama" name="username" required />
          <input type="email" placeholder="E-mail" name="email" required />
          <textarea
            cols="30"
            rows="10"
            placeholder="Tulis Ulasan Anda"
            name="ulasan"
            required
          ></textarea>
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
                <a href="https://www.instagram.com/baksomasroy/"
                  ><i class="fab fa-instagram icon"></i
                ></a>
              </li>
              <li>
                <a href="https://www.tiktok.com/@baksomasroy?lang=en"
                  ><i class="fa-brands fa-tiktok icon"></i
                ></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <hr class="betmut" />
    </section>

    <footer>
      <p>© 2025 Bakso Mas Roy. All rights reserved.</p>
      <a href="terms-of-services.php" style="text-decoration: none; color: #000"
        >Terms of Services</a
      >
      <p>Privacy Policy</p>
    </footer>

    <script src="js/script.js"></script>
  </body>
</html>
