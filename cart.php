<?php
session_start();
include 'functions.php';

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

if (!isset($_SESSION['login'])) {
  header("Location: index.php");
  exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$produk_list = [];
if (!empty($cart)) {
  $ids = implode(",", array_keys($cart));
  $query = mysqli_query($conn, "SELECT * FROM produk WHERE id IN ($ids)");

  while ($row = mysqli_fetch_assoc($query)) {
    $row['qty'] = $cart[$row['id']];
    $produk_list[] = $row;
  }
}
$total_harga = 0;
foreach ($produk_list as $p) {
  $total_harga += $p['harga'] * $p['qty'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bakso Campur</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link rel="stylesheet" href="css/cart.css" />
  <link rel="icon" type="image/png" href="css/properties/logo.png" />
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

  <section id="cart-page" class="cart-page">
    <div class="cart-header">
      <div class="breadcrumb">
        <a href="index.php">Beranda</a>
        <span>›</span>
        <span>User Profile</span>
      </div>
      <div class="cart-title">
        <h1>Keranjang</h1>
      </div>
    </div>

    <div class="cart-wrapper">
      <div class="cart-content">
        <div class="left-section">
          <div class="left-content">
            <?php if (!empty($produk_list)): ?>
              <div class="user-address">
                <label for="outlet-select">Pilih Cabang Outlet:</label>
                <select id="outlet-select" name="outlet">
                  <option value="">-- Pilih Cabang --</option>
                  <option value="Cabang Merr - Sukolilo, Surabaya">
                    Cabang Merr - Sukolilo, Surabaya
                  </option>
                  <option value="Cabang Dukuh Kupang - Sawahan, Surabaya">
                    Cabang Dukuh Kupang - Sawahan, Surabaya
                  </option>
                  <option value="Cabang Sawotratap Aloha - Gedangan, Sidoarjo">
                    Cabang Sawotratap Aloha - Gedangan, Sidoarjo
                  </option>
                </select>
              </div>
            <?php endif; ?>

            <div class="cart-items-container">
              <?php if (empty($produk_list)): ?>

                <p>Keranjang masih kosong.</p>

              <?php else: ?>

                <?php foreach ($produk_list as $p): ?>
                  <div class="cart-item">
                    <div class="item-image">
                      <img src="<?= $p['image']; ?>" alt="<?= $p['nama']; ?>" />
                    </div>

                    <div class="item-detail">
                      <div class="item-name"><?= $p['nama']; ?></div>
                      <div class="item-price">Rp. <?= number_format($p['harga'], 0, ',', '.'); ?></div>
                    </div>

                    <div class="item-count" data-id="<?= $p['id']; ?>">
                      <button type="button" class="quantity-btn decrease">-</button>
                      <span class="quantity-display"><?= $p['qty']; ?></span>
                      <button type="button" class="quantity-btn increase">+</button>
                    </div>
                  </div>
                <?php endforeach; ?>

              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="right-section">
          <div class="right-content">
            <div class="right-header">
              <h2>Ringkasan Belanja</h2>
            </div>

            <div class="item-summary">
              <?php foreach ($produk_list as $p): ?>
                <div class="items" data-id="<?= $p['id']; ?>">
                  <div class="item-name"><?= $p['nama']; ?></div>
                  <div class="item-count summary-count"><?= $p['qty']; ?>x</div>
                  <div class="item-price">Rp. <?= number_format($p['harga'], 0, ',', '.'); ?></div>
                </div>
              <?php endforeach; ?>

              <div class="total">
                <div class="total-header">Total</div>
                <div class="total-price">
                  Rp. <?= number_format($total_harga, 0, ',', '.'); ?>
                </div>
              </div>
            </div>

            <div class="metode-pembayaran">
              <div class="metode-pembayaran-header">
                <h2>Metode Pembayaran</h2>
              </div>
              <div class="metode-pembayaran-content">
                <div class="metode-pembayaran-item">
                  <input type="radio" name="metode-pembayaran" id="cod" value="cod" />
                  <label for="cod">Bayar Ditempat</label>
                </div>
                <div class="metode-pembayaran-item">
                  <input type="radio" name="metode-pembayaran" id="qris" value="qris" />
                  <label for="transfer">Qris</label>
                </div>
              </div>

            </div>
            <div class="cta-buy-now">
              <a id="btnCheckout" style="cursor:pointer;">Bayar Sekarang</a>
            </div>
          </div>
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
  document.addEventListener("DOMContentLoaded", () => {

    // ==========================
    // USER DROPDOWN
    // ==========================
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


    // ==========================
    // QUANTITY (+ / -)
    // ==========================
    document.querySelectorAll(".item-count").forEach((box) => {
      const productId = box.dataset.id;
      const display = box.querySelector(".quantity-display");
      const decreaseBtn = box.querySelector(".decrease");
      const increaseBtn = box.querySelector(".increase");

      function updateQty(action) {
        fetch("update_qty.php", {
          method: "POST",
          body: new URLSearchParams({
            product_id: productId,
            action: action,
          }),
        })
          .then(res => res.json())
          .then(data => {
            if (data.status !== "success") return;

            let newQty = action === "increase" ?
              parseInt(display.textContent) + 1 :
              parseInt(display.textContent) - 1;

            // update kiri
            if (newQty <= 0) {
              box.closest('.cart-item').style.display = "none";
            } else {
              display.textContent = newQty;
            }

            // update ringkasan kanan
            const summaryItem = document.querySelector(`.items[data-id="${productId}"] .summary-count`);
            if (summaryItem) {
              if (newQty <= 0) {
                summaryItem.closest('.items').style.display = "none";
              } else {
                summaryItem.textContent = newQty + "x";
              }
            }

            // update total harga
            const totalBox = document.querySelector(".total-price");
            if (totalBox) {
              totalBox.textContent = "Rp. " + data.total_harga.toLocaleString("id-ID");
            }

            // reload kalau keranjang kosong
            if (data.total_harga === 0) {
              location.reload();
            }
          });
      }

      if (increaseBtn) increaseBtn.addEventListener("click", () => updateQty("increase"));
      if (decreaseBtn) decreaseBtn.addEventListener("click", () => updateQty("decrease"));
    });


    // ==========================
    // CHECKOUT (PAKE REDIRECT)
    // ==========================
    const outletSelect = document.getElementById("outlet-select");
    const metodeRadio = document.querySelectorAll('input[name="metode-pembayaran"]');
    const btnCheckout = document.getElementById("btnCheckout");

    if (btnCheckout) {
      btnCheckout.addEventListener("click", () => {
        const outlet = outletSelect.value;
        const metode = [...metodeRadio].find(r => r.checked);

        if (!outlet) {
          alert("Pilih outlet dahulu.");
          return;
        }
        if (!metode) {
          alert("Pilih metode pembayaran dahulu.");
          return;
        }

        // redirect
        window.location.href = `checkout.php?outlet=${encodeURIComponent(outlet)}&method=${encodeURIComponent(metode.id)}`;
      });
    }

  });
</script>


</html>