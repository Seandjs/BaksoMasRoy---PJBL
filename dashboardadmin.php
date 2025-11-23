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

if (!isset($_SESSION["login"])) {
  header("Location: login-admin.php");
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM produk");

$penjualanQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE MONTH(tanggal) = MONTH(CURRENT_DATE()) AND YEAR(tanggal) = YEAR(CURRENT_DATE())");
$penjualan = mysqli_fetch_assoc($penjualanQuery)["total"];

$pendapatanQuery = mysqli_query($conn, "
    SELECT SUM(total_harga) AS total 
    FROM orders 
    WHERE MONTH(tanggal) = MONTH(CURRENT_DATE())
    AND YEAR(tanggal) = YEAR(CURRENT_DATE())
");
$pendapatan = mysqli_fetch_assoc($pendapatanQuery)['total'] ?? 0;

$pelangganQuery = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM user
");
$pelanggan = mysqli_fetch_assoc($pelangganQuery)['total'];

if (isset($_POST["submit"])) {

  $nama = htmlspecialchars($_POST["nama"]);
  $kategori = htmlspecialchars($_POST["kategori"]);
  $harga = htmlspecialchars(preg_replace('/[^0-9]/', '', $_POST["harga"]));
  $deskripsi = htmlspecialchars($_POST["deskripsi"]);

  $gambarName = $_FILES["image"]["name"];
  $gambarTmp = $_FILES["image"]["tmp_name"];
  $folder = "uploads/" . $gambarName;
  move_uploaded_file($gambarTmp, $folder);

  $query = "INSERT INTO produk (nama, kategori, harga, deskripsi, image)
              VALUES ('$nama', '$kategori', '$harga', '$deskripsi', '$folder')";

  if (mysqli_query($conn, $query)) {
    echo "<script>alert('Produk berhasil ditambahkan!');</script>";
    echo "<script>window.location.href = 'dashboardadmin.php';</script>";
    exit;
  } else {
    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
  }
}

$ulasan = mysqli_query($conn, "SELECT * FROM ulasan 
                               ORDER BY status='unread' DESC, id DESC");

$activityQuery = mysqli_query($conn, "
    SELECT 
        orders.id,
        orders.order_code,
        orders.tanggal,
        orders.outlet,
        orders.total_harga,
        user.username AS nama_user
    FROM orders
    LEFT JOIN user ON orders.user_id = user.id
    ORDER BY orders.tanggal DESC
    LIMIT 10
");

function getOrderItems($conn, $orderId)
{
  $q = mysqli_query($conn, "
        SELECT nama, qty 
        FROM order_detail 
        WHERE order_id = $orderId
    ");

  $items = [];
  while ($row = mysqli_fetch_assoc($q)) {
    $items[] = $row['nama'] . " x" . $row['qty'];
  }
  return implode(", ", $items);
}

$pesananQuery = mysqli_query($conn, "
    SELECT 
        orders.id,
        orders.order_code,
        orders.tanggal,
        orders.outlet,
        orders.total_harga,
        user.username AS nama_user
    FROM orders
    LEFT JOIN user ON orders.user_id = user.id
    ORDER BY orders.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport  " content="width=device-width,initial-scale=1" />
  <title>Bakso Masroy - Admin Panel</title>
  <link rel="stylesheet" href="css/dashboardadmin.css" />
  <link rel="icon" type="image/png" href="css/properties/logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

</head>

<body>
  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="brand">
        <div class="brand-logo">
          <img src="css/properties/logo.png" alt="logo" />
        </div>
        <div class="brand-name">
          <h2>Bakso Mas Roy</h2>
          <p>Admin Panel</p>
        </div>
      </div>
    </div>

    <nav class="sidebar-nav">
      <button class="nav-item active" data-page="statistik">
        <i class="fa-solid fa-house"></i>
        Dashboard
      </button>

      <button class="nav-item" data-page="produk">
        <i class="fa-solid fa-cube"></i>
        Kelola Produk
      </button>

      <button class="nav-item" data-page="pesanan">
        <i class="fa-solid fa-bag-shopping"></i>
        Pesanan
      </button>

      <button class="nav-item" data-page="pesan">
        <i class="fa-solid fa-message"></i>
        Pesan
      </button>

      <button class="nav-item logout-btn" onclick="logout()">

        <a href="logout-admin.php">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
      </button>
    </nav>
  </div>

  <!-- MAIN -->
  <div class="main-section" id="main-section">
    <header class="header">
      <button class="hamburger-menu">
        <i class="fa-solid fa-bars"></i>
      </button>

      <div class="admin-info">
        <div class="admin-details">
          <p>Admin1</p>
          <span>@kara</span>
        </div>
        <div class="admin-avatar">
          <img src="css/properties/logo.png" alt="ava" />
        </div>
      </div>
    </header>

    <div class="stat-page" id="page-statistik">
      <div class="header-stat-page">
        <h2>Dashboard Statistik</h2>
      </div>

      <div class="stat-card-container">
        <div class="stat-card penjualan">
          <div class="stat-info">
            <p>Penjualan Bulan Ini</p>
            <h3>
              <?= $penjualan ?> Pesanan
            </h3>
            <!-- <span class="trend">↑ 12% dari bulan kemarin</span> -->
          </div>
          <div class="stat-icon penjualan">
            <i class="fa-solid fa-chart-line"></i>
          </div>
        </div>

        <div class="stat-card pendapatan">
          <div class="stat-info">
            <p>Pendapatan Bulan Ini</p>
            <h3>Rp <?= number_format($pendapatan, 0, ',', '.') ?></h3>
            <!-- <span class="trend">↑ 1% dari bulan kemarin</span> -->
          </div>
          <div class="stat-icon pendapatan">
            <i class="fa-solid fa-money-bill-wave"></i>
          </div>
        </div>

        <div class="stat-card pelanggan">
          <div class="stat-info">
            <p>Total Pelanggan Bulan Ini</p>
            <h3><?= $pelanggan ?> Pelanggan</h3>
            <!-- <span class="trend">↑ 2% dari bulan kemarin</span> -->
          </div>
          <div class="stat-icon pelanggan">
            <i class="fa-solid fa-users"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="activity-card">
      <h2>Aktivitas Terkini</h2>
      <div class="activity-log-container">

        <?php while ($a = mysqli_fetch_assoc($activityQuery)): ?>
          <div class="activity-item">
            <div class="activity-details">
              <p>
                Pesanan atas nama
                <span><?= htmlspecialchars($a['nama_user'] ?? 'Guest'); ?></span>
                –
                <span>
                  <?= getOrderItems($conn, $a['id']); ?>
                </span>
              </p>

              <p>
                Tanggal:
                <span><?= date("d M Y H:i", strtotime($a['tanggal'])); ?></span>
              </p>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>


    <div class="product-page hidden" id="page-produk">
      <div class="product-header">
        <h2>Kelola Produk</h2>
        <button class="btn-tambah">
          <i class="fa-solid fa-plus"></i> Tambah Produk
        </button>
      </div>

      <div class="pembungkusluar" id="produkList">
        <?php
        while ($row = mysqli_fetch_assoc($result)):
          $hargaFormatted = "Rp " . number_format($row["harga"], 0, ',', '.');
          ?>
          <div class="produk-item">
            <div class="container">
              <div class="foto-produk">
                <div class="shimmer"></div>
                <img src="<?= $row["image"]; ?>" alt="<?= $row["nama"]; ?>" />
              </div>
              <div class="judul">
                <h4><?= $row["kategori"]; ?></h4>
              </div>
              <div class="nama">
                <h3><?= $row["nama"]; ?></h3>
              </div>
              <div class="deskripsi">
                <p>
                  <?= $row["deskripsi"]; ?>
                </p>
              </div>
              <div class="hargapesan">
                <div class="harga-produk">
                  <h3><?= $row["harga"]; ?></h3>
                </div>
                <div class="action-buttons">

                  <button class="btn-action btn-edit" title="Edit Produk" onclick="openEditPopup(
                  <?= $row['id']; ?>,
                  '<?= htmlspecialchars($row['nama'], ENT_QUOTES); ?>',
                  '<?= htmlspecialchars($row['kategori'], ENT_QUOTES); ?>',
                  '<?= htmlspecialchars($row['deskripsi'], ENT_QUOTES); ?>',
                  '<?= htmlspecialchars($row['image'], ENT_QUOTES); ?>',
                   <?= $row['harga']; ?>
                   )">
                    <i class="fa-solid fa-pen"></i>
                  </button>

                  <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-action btn-delete" title="Hapus Produk"
                    onclick="return confirm('Yakin hapus produk ini?')">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- PESANAN (tetap) -->
    <div class="pesanan-page hidden" id="page-pesanan">
      <div class="pesanan-header">
        <h2>Kelola Pesanan</h2>
      </div>
      <input type="text" id="searchPesanan" placeholder="Cari pesanan..."
        style="padding:10px; width:100%; margin-bottom:15px; margin-top:-10px; border:1px solid #ccc; border-radius:8px;">

      <div class="pesanan-container" id="pesananResults">

        <?php while ($p = mysqli_fetch_assoc($pesananQuery)): ?>
          <div class="pesanan-card">

            <div class="pesanan-header-card">
              <span class="pesanan-id">#<?= htmlspecialchars($p['order_code']); ?></span>
            </div>

            <div class="pesanan-body">

              <div class="pesanan-info-item">
                <label>Nama Pelanggan</label>
                <span><?= htmlspecialchars($p['nama_user'] ?? 'Guest'); ?></span>
              </div>

              <div class="pesanan-info-item">
                <label>Pesanan</label>
                <span><?= getOrderItems($conn, $p['id']); ?></span>
              </div>

              <div class="pesanan-info-item">
                <label>Outlet</label>
                <span><?= htmlspecialchars($p['outlet']); ?></span>
              </div>

              <div class="pesanan-info-item">
                <label>Tanggal Pesan</label>
                <span><?= date("d M Y, H:i", strtotime($p['tanggal'])); ?></span>
              </div>

              <div class="pesanan-info-item">
                <label>Total Pembayaran</label>
                <span class="pesanan-total">
                  Rp <?= number_format($p['total_harga'], 0, ',', '.'); ?>
                </span>
              </div>

            </div>

          </div>
        <?php endwhile; ?>

      </div>
    </div>


    <!-- PESAN (tetap) -->
    <div class="pesan-page hidden" id="page-pesan">
      <div class="pesan-header">
        <h2>Ulasan Pelanggan</h2>
      </div>
      <div class="pesan-container">

        <?php while ($row = mysqli_fetch_assoc($ulasan)): ?>
          <div class="pesan-card <?= $row['status'] == 'unread' ? 'unread' : '' ?>">
            <div class="pesan-header-card">
              <div class="pesan-sender">
                <div class="sender-avatar"><?= strtoupper(substr($row['username'], 0, 2)); ?></div>
                <div class="sender-info">
                  <h4><?= htmlspecialchars($row['username']); ?></h4>
                  <p><?= htmlspecialchars($row['email']); ?></p>
                </div>
              </div>
              <span class="pesan-time">Baru saja</span>
            </div>

            <div class="pesan-content">
              <div class="pesan-text"><?= htmlspecialchars_decode($row['ulasan']); ?></div>
            </div>

            <div class="pesan-actions">
              <?php if ($row['status'] == 'unread'): ?>
                <form action="tandai.php" method="POST" style="display:inline;">
                  <input type="hidden" name="id" value="<?= $row['id']; ?>">
                  <button class="btn-balas" type="submit">
                    <i class="fa-solid fa-eye"></i> Tandai Dibaca
                  </button>
                </form>
              <?php endif; ?>

              <form action="hapus_ulasan.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <button class="btn-hapus-pesan" type="submit">
                  <i class="fa-solid fa-trash"></i> Hapus
                </button>
              </form>
            </div>
          </div>
        <?php endwhile; ?>

      </div>
    </div>
  </div>

  <!-- POPUP (AWALNYA DISSEMBUNYIKAN) -->
  <div class="popup-overlay" id="popupProduk" aria-hidden="true">
    <div class="popup-content" role="dialog" aria-modal="true" aria-labelledby="popupTitle" id="popupContent">
      <span class="close-popup" id="closePopup" aria-label="Tutup">&times;</span>
      <h2 id="popupTitle">Tambah Produk</h2>

      <form id="formProduk" autocomplete="off" action="dashboardadmin.php" method="post" enctype="multipart/form-data">
        <div>
          <input type="hidden" name="id" id="produkId">
          <label for="namaProduk">Nama Produk</label>
          <input type="text" id="nama" placeholder="Contoh: Bakso Campur" name="nama" required />
        </div>

        <div>
          <label for="kategori">Kategori</label>
          <select id="kategori" name="kategori" required>
            <option value="" disabled selected>Pilih Kategori</option>
            <option value="Makanan">Makanan</option>
            <option value="Minuman">Minuman</option>
          </select>
        </div>

        <div>
          <label for="harga">Harga</label>
          <input type="text" id="harga" placeholder="Contoh: Rp 31.000" name="harga" required />
        </div>

        <div class="form-textarea-wrapper">
          <label for="deskripsi" style="display: block; margin-bottom: 8px">Deskripsi</label>
          <textarea id="deskripsi" placeholder="Masukkan deskripsi produk..." name="deskripsi" required></textarea>
        </div>

        <div>
          <label for="gambar">Upload Gambar</label>
          <input type="file" accept="image/*" id="image" placeholder="properties/BaksoCampur.png" name="image" />
        </div>

        <button type="submit" name="submit" class="btn-submit" id="submit">
          Simpan Produk
        </button>
      </form>
    </div>
  </div>
</body>
<script>
  document.addEventListener("DOMContentLoaded", () => {

    const body = document.body;
    const popup = document.getElementById("popupProduk");
    const popupContent = document.getElementById("popupContent");
    const popupTitle = document.getElementById("popupTitle");
    const closePopupBtn = document.getElementById("closePopup");
    const form = document.getElementById("formProduk");
    const submitButton = document.getElementById("submit");
    const btnTambah = document.querySelector(".btn-tambah");
    const editButtons = document.querySelectorAll(".btn-edit");
    const hargaInput = document.getElementById("harga");

    /* ----------- SAFE CHECK UNTUK ELEMEN ----------- */
    const safe = (el) => el !== null && el !== undefined;

    /* ----------- FORMAT RUPIAH ----------- */
    function formatRupiah(angka) {
      const numberString = angka.replace(/[^0-9]/g, '');
      const number = parseInt(numberString);
      if (isNaN(number)) return '';
      return 'Rp ' + number.toLocaleString('id-ID');
    }

    if (safe(hargaInput)) {
      hargaInput.addEventListener("input", function () {
        const cursorPos = this.selectionStart;
        const oldLength = this.value.length;
        const formatted = formatRupiah(this.value);
        this.value = formatted;
        const newLength = formatted.length;
        const diff = newLength - oldLength;
        this.setSelectionRange(cursorPos + diff, cursorPos + diff);
      });
    }

    /* ----------- POPUP OPEN ----------- */
    function openPopup(mode = "tambah", data = null) {
      if (!safe(popup)) return;

      popup.classList.add("open");
      popup.style.display = "block";
      body.style.overflow = "hidden";

      const imageInput = document.getElementById("image");
      if (safe(imageInput)) {
        imageInput.required = mode === "tambah";
      }

      popupTitle.textContent = mode === "edit" ? "Edit Produk" : "Tambah Produk";
      form.action = mode === "edit" ? "update.php" : "dashboardadmin.php";
      submitButton.name = mode === "edit" ? "update" : "submit";
      submitButton.textContent = mode === "edit" ? "Perbarui Produk" : "Simpan Produk";

      if (mode === "edit" && data) {
        document.getElementById("produkId").value = data.id;
        document.getElementById("nama").value = data.nama;
        document.getElementById("kategori").value = data.kategori;
        document.getElementById("deskripsi").value = data.deskripsi;
        document.getElementById("harga").value = formatRupiah(data.harga.toString());
      } else {
        form.reset();
      }
    }

    /* ----------- POPUP CLOSE ----------- */
    function closePopup() {
      if (!safe(popup)) return;

      popup.classList.remove("open");
      popup.style.display = "none";
      body.style.overflow = "";
      form.reset();

      popupTitle.textContent = "Tambah Produk";
      form.action = "dashboardadmin.php";
      submitButton.name = "submit";
      submitButton.textContent = "Simpan Produk";
    }

    if (safe(closePopupBtn)) {
      closePopupBtn.addEventListener("click", closePopup);
    }

    if (safe(btnTambah)) {
      btnTambah.addEventListener("click", (e) => {
        e.stopPropagation();
        openPopup("tambah");
      });
    }

    /* ----------- EDIT BUTTONS ----------- */
    editButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const card = btn.closest(".produk-item");
        if (!card) return;

        const nama = card.querySelector(".nama h3")?.textContent.trim() || "";
        const kategori = card.querySelector(".judul h4")?.textContent.trim() || "";
        const deskripsi = card.querySelector(".deskripsi p")?.textContent.trim() || "";
        const hargaText = card.querySelector(".harga-produk h3")?.textContent.replace(/[^0-9]/g, '') || "";
        const id = card.querySelector(".btn-edit").getAttribute("onclick").match(/\d+/)[0];

        openPopup("edit", {
          id, nama, kategori, deskripsi, harga: hargaText
        });
      });
    });

    /* ----------- NAVIGASI HALAMAN ----------- */
    const navItems = document.querySelectorAll(".nav-item[data-page]");
    const pages = {
      statistik: document.getElementById("page-statistik"),
      produk: document.getElementById("page-produk"),
      pesanan: document.getElementById("page-pesanan"),
      pesan: document.getElementById("page-pesan"),
    };

    navItems.forEach((item) => {
      item.addEventListener("click", function () {
        const pageName = this.getAttribute("data-page");

        navItems.forEach((n) => n.classList.remove("active"));
        this.classList.add("active");

        Object.values(pages).forEach((pg) => safe(pg) && pg.classList.add("hidden"));
        if (safe(pages[pageName])) pages[pageName].classList.remove("hidden");

        const activity = document.querySelector(".activity-card");
        if (safe(activity)) {
          activity.classList.toggle("hidden", pageName !== "statistik");
        }
      });
    });

    /* ----------- EFEK 3D PRODUK ----------- */
    const produkItems = document.querySelectorAll(".produk-item");
    produkItems.forEach((item) => {
      const container = item.querySelector(".container");
      if (!safe(container)) return;

      item.addEventListener("mousemove", (e) => {
        const rect = item.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const rotateX = (y - rect.height / 2) / 10;
        const rotateY = (rect.width / 2 - x) / 10;
        container.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
      });

      item.addEventListener("mouseleave", () => {
        container.style.transform = "rotateX(0) rotateY(0)";
      });
    });

    /* ----------- GLOBAL FUNCTION UNTUK POPUP EDIT ----------- */
    window.openEditPopup = (id, nama, kategori, deskripsi, image, harga) => {
      openPopup("edit", { id, nama, kategori, deskripsi, harga });
    };

  });
  document.getElementById("searchPesanan").addEventListener("keyup", function () {
    const keyword = this.value;

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "search_pesanan.php?keyword=" + keyword, true);

    xhr.onload = function () {
        document.getElementById("pesananResults").innerHTML = this.responseText;
    };

    xhr.send();
});

</script>



</html>