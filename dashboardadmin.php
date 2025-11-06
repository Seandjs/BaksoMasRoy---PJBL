<?php
session_start();
require 'functions.php';

if (!isset($_SESSION["login"])) {
  header("Location: login-admin.php");
  exit;
}

$result = mysqli_query($conn, "SELECT * FROM produk");

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

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Bakso Masroy - Admin Panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
      border: none;
    }

    body {
      background-color: var(--background);
    }

    body .active {
      overflow: hidden;
    }

    :root {
      --background: #fff8e1;
      --primary: #fbd244;
      --secondary: #7b341d;
      --dark: #000000;
      --light: #f0f0f0;
      --blue: #1a237e;
      --icon-orange: #ff9800;
      --icon-teal: #009688;
      --icon-brown: #6d4c41;
      --icon-orange-light: #ffb74d;
      --icon-teal-light: #26a69a;
      --icon-brown-light: #8d6e63;
    }

    .hidden {
      display: none !important;
    }

    .sidebar {
      position: fixed;
      display: flex;
      flex-direction: column;
      height: 100%;
      background-color: var(--primary);
      width: 260px;
      box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
      z-index: 100;
    }

    .sidebar-header {
      padding: 24px;
    }

    .sidebar-header::after {
      margin-top: 20px;
      content: "";
      display: block;
      width: 100%;
      height: 0.5px;
      background-color: var(--dark);
      opacity: 0.2;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .brand-logo {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, var(--primary) 0%, #f5a623 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(123, 52, 29, 0.15);
      transition: all 0.3s ease;
      border: solid 0.5px var(--dark);
    }

    .brand-logo:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(123, 52, 29, 0.25);
    }

    .brand-logo img {
      width: 30px;
    }

    .brand-name h2 {
      font-size: 18px;
      font-weight: 600;
      color: var(--dark);
    }

    .brand-name p {
      font-size: 12px;
      color: var(--secondary);
      opacity: 0.8;
    }

    nav.sidebar-nav {
      margin-top: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      margin-left: 20px;
      margin-right: 20px;
      margin-bottom: 15px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
      background: transparent;
      border: none;
      width: 80%;
      text-align: left;
      font-size: 15px;
      color: var(--dark);
      opacity: 0.7;
      font-weight: 500;
    }

    .nav-item:hover {
      background: rgba(123, 52, 29, 0.08);
      opacity: 1;
      transform: translateX(5px);
    }

    .nav-item.active {
      background: var(--secondary);
      color: var(--light);
      opacity: 1;
      box-shadow: 0 2px 8px rgba(123, 52, 29, 0.3);
    }

    .logout-btn {
      position: absolute;
      bottom: 20px;
      color: #d32f2f;
      font-weight: 500;
    }

    .logout-btn::before {
      content: "";
      position: absolute;
      top: -15px;
      left: 0;
      right: 0;
      height: 0.5px;
      background-color: var(--dark);
      opacity: 0.2;
    }

    .logout-btn:hover {
      background: rgba(211, 47, 47, 0.08);
      color: #b71c1c;
    }

    .main-section {
      margin-left: 260px;
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background-color: var(--primary);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.175);
      border-radius: 8px;
    }

    .hamburger-menu {
      font-size: 24px;
      background: none;
      cursor: pointer;
      color: var(--dark);
      transition: all 0.3s ease-in-out;
    }

    .hamburger-menu:hover {
      transform: scale(1.1);
    }

    .admin-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .admin-details p {
      font-size: 14px;
      font-weight: 600;
      color: var(--dark);
      text-align: right;
    }

    .admin-details span {
      font-size: 12px;
      color: var(--secondary);
      opacity: 0.8;
    }

    .admin-avatar {
      width: 48px;
      height: 48px;
      background: linear-gradient(135deg, var(--primary) 0%, #f5a623 100%);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(123, 52, 29, 0.15);
      transition: all 0.3s ease;
      border: solid 0.5px var(--dark);
      cursor: pointer;
    }

    .admin-avatar:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(123, 52, 29, 0.25);
    }

    .admin-avatar img {
      width: 25px;
    }

    /* DASHBOARD STATISTIK */
    .stat-page {
      margin-top: 20px;
    }

    .stat-page::after {
      content: "";
      display: block;
      width: 100%;
      height: 0.5px;
      background-color: var(--dark);
      opacity: 0.2;
      margin-top: 30px;
    }

    .header-stat-page h2 {
      font-size: 32px;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 20px;
    }

    .stat-card-container {
      margin-top: 20px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      max-width: 95%;
      position: relative;
      margin: 0 auto;
    }

    .stat-card {
      background-color: var(--light);
      border-radius: 12px;
      padding: 20px;
      height: 150px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s ease;
      margin-left: 20px;
      margin-right: 20px;
      border-left: 4px solid;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-info p {
      font-size: 14px;
      color: var(--dark);
      margin-bottom: 20px;
      font-weight: 300;
    }

    .stat-info h3 {
      font-size: 24px;
      color: var(--dark);
      margin-bottom: 20px;
      font-weight: 600;
    }

    .trend {
      font-size: 12px;
      color: #05762d;
      opacity: 0.8;
      font-weight: bold;
    }

    .stat-card.penjualan {
      border-color: var(--icon-orange);
    }

    .stat-card.pendapatan {
      border-color: var(--icon-brown);
    }

    .stat-card.pelanggan {
      border-color: var(--icon-teal);
    }

    .stat-icon {
      font-size: 36px;
      padding: 15px;
      border-radius: 50%;
      color: var(--light);
      width: 80px;
      text-align: center;
      transition: all 0.3s ease-in-out;
    }

    .stat-icon.penjualan {
      background-color: var(--icon-orange);
      border: solid 4px var(--icon-orange-light);
      box-shadow: 0 2px 8px rgba(255, 152, 0, 0.3);
      color: var(--light);
    }

    .stat-icon.pendapatan {
      background-color: var(--icon-brown);
      border: solid 4px var(--icon-brown-light);
      box-shadow: 0 2px 8px rgba(165, 42, 42, 0.3);
    }

    .stat-icon.pelanggan {
      background-color: var(--icon-teal);
      border: solid 4px var(--icon-teal-light);
      box-shadow: 0 2px 8px rgba(0, 150, 136, 0.3);
    }

    .stat-icon i {
      color: var(--light);
    }

    .stat-icon:hover {
      transform: scale(1.1);
    }

    .activity-card {
      margin-top: 20px;
    }

    .activity-card h2 {
      font-size: 32px;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 20px;
    }

    .activity-log-container {
      max-width: 100%;
      max-height: 400px;
      overflow-y: auto;
      padding: 25px;
      padding-right: 10px;
      background-color: var(--light);
      border-radius: 12px;
      margin: 0 auto;
      margin-left: 20px;
      margin-right: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .activity-log-container::-webkit-scrollbar {
      width: 6px;
    }

    .activity-log-container::-webkit-scrollbar-track {
      background: rgba(0, 0, 0, 0.05);
      border-radius: 10px;
    }

    .activity-log-container::-webkit-scrollbar-thumb {
      background: var(--primary);
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .activity-log-container::-webkit-scrollbar-thumb:hover {
      background: var(--secondary);
    }

    .activity-item {
      position: relative;
      padding: 20px;
      padding-left: 50px;
      margin-bottom: 15px;
      background: white;
      border-radius: 10px;
      border-left: 4px solid;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .activity-item:hover {
      transform: translateX(5px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .activity-item.done {
      border-color: var(--icon-teal);
      background: linear-gradient(to right, rgba(0, 150, 136, 0.05), white);
    }

    .activity-item.sending {
      border-color: var(--blue);
      background: linear-gradient(to right, rgba(26, 35, 126, 0.05), white);
    }

    .activity-item.process {
      border-color: var(--icon-orange);
      background: linear-gradient(to right, rgba(255, 152, 0, 0.05), white);
    }

    .activity-dot {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      border-radius: 50%;
      border: 3px solid white;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      animation: pulse 2s infinite;
    }

    .activity-dot.done {
      background-color: var(--icon-teal);
    }

    .activity-dot.sending {
      background-color: var(--blue);
    }

    .activity-dot.process {
      background-color: var(--icon-orange);
    }

    @keyframes pulse {

      0%,
      100% {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      }

      50% {
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3),
          0 0 0 5px rgba(255, 255, 255, 0.3);
      }
    }

    .activity-details p {
      font-size: 14px;
      color: var(--dark);
      margin-bottom: 8px;
      line-height: 1.5;
    }

    .activity-details p:first-child {
      font-weight: 500;
      font-size: 15px;
      margin-bottom: 10px;
    }

    .activity-details p span {
      font-weight: 600;
      color: var(--secondary);
    }

    .activity-details p:nth-child(2) span {
      padding: 3px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: 600;
      color: white;
    }

    .activity-item.done .activity-details p:nth-child(2) span {
      background-color: var(--icon-teal);
    }

    .activity-item.sending .activity-details p:nth-child(2) span {
      background-color: var(--blue);
    }

    .activity-item.process .activity-details p:nth-child(2) span {
      background-color: var(--icon-orange);
    }

    .activity-details p:last-child {
      font-size: 12px;
      color: rgba(0, 0, 0, 0.5);
      font-weight: 400;
    }

    .activity-details p:last-child span {
      color: rgba(0, 0, 0, 0.6);
      font-weight: 500;
    }

    /* PRODUCT PAGE */
    .product-page {
      margin-top: 20px;
    }

    .product-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .product-header h2 {
      font-size: 32px;
      font-weight: 600;
      color: var(--dark);
    }

    .btn-tambah {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 24px;
      background: var(--secondary);
      color: white;
      border: 1px solid var(--dark);
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(123, 52, 29, 0.3);
    }

    .btn-tambah:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(123, 52, 29, 0.4);
      background: #5a2716;
    }

    .btn-tambah i {
      font-size: 16px;
    }

    .pembungkusluar {
      display: flex;
      gap: 30px;
      flex-wrap: wrap;
      justify-content: center;
      max-width: 1400px;
      margin: 0 auto;
    }

    .pembungkusluar .produk-item {
      width: 280px;
      height: 440px;
      perspective: 1000px;
      cursor: pointer;
    }

    .pembungkusluar .container {
      width: 100%;
      height: 100%;
      position: relative;
      transition: transform 0.1s ease;
      transform-style: preserve-3d;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
      display: flex;
      flex-direction: column;
    }

    .pembungkusluar .foto-produk {
      height: 200px;
      width: 100%;
      overflow: hidden;
      position: relative;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .pembungkusluar .foto-produk img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .pembungkusluar .produk-item:hover .foto-produk img {
      transform: scale(1.1);
    }

    .shimmer {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(45deg,
          transparent 30%,
          rgba(255, 255, 255, 0.3) 50%,
          transparent 70%);
      transform: translateX(-100%);
      transition: transform 0.6s ease;
      pointer-events: none;
      z-index: 2;
    }

    .pembungkusluar .produk-item:hover .shimmer {
      transform: translateX(100%);
    }

    .pembungkusluar .judul {
      padding: 15px 20px 8px 20px;
    }

    .pembungkusluar .judul h4 {
      display: inline-block;
      color: #8b5a00;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      background: linear-gradient(135deg, #fbd244 0%, #f5dd86 100%);
    }

    .pembungkusluar .nama {
      padding: 8px 20px 4px 20px;
    }

    .pembungkusluar .nama h3 {
      font-size: 20px;
      color: #000000;
      font-weight: 700;
    }

    .pembungkusluar .deskripsi {
      padding: 4px 20px 15px 20px;
      flex-grow: 1;
      display: flex;
      align-items: flex-start;
    }

    .pembungkusluar .deskripsi p {
      font-size: 12px;
      color: #718096;
      line-height: 1.6;
    }

    .pembungkusluar .hargapesan {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 20px;
      border-top: 1px solid #e2e8f0;
      background: linear-gradient(to bottom,
          transparent,
          rgba(251, 210, 68, 0.1));
      margin-top: auto;
    }

    .pembungkusluar .harga-produk h3 {
      font-size: 20px;
      color: var(--secondary);
      font-weight: 700;
    }

    .pembungkusluar .action-buttons {
      display: flex;
      gap: 8px;
    }

    .pembungkusluar .btn-action {
      text-decoration: none;
      color: white;
      padding: 8px 12px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 12px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: 1px solid var(--dark);
      cursor: pointer;
    }

    .pembungkusluar .btn-edit {
      background: var(--blue);
    }

    .pembungkusluar .btn-edit:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(26, 35, 126, 0.4);
      background: #0d1642;
    }

    .pembungkusluar .btn-delete {
      background: #d32f2f;
    }

    .pembungkusluar .btn-delete:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(211, 47, 47, 0.4);
      background: #b71c1c;
    }

    /* PESANAN PAGE */
    .pesanan-page {
      margin-top: 20px;
    }

    .pesanan-header h2 {
      font-size: 32px;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 30px;
    }

    .pesanan-container {
      max-width: 100%;
      margin: 0 auto;
    }

    .pesanan-card {
      background: var(--light);
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      border-left: 4px solid;
    }

    .pesanan-card.process {
      border-color: var(--icon-orange);
    }

    .pesanan-card.sending {
      border-color: var(--blue);
    }

    .pesanan-card.done {
      border-color: var(--icon-teal);
    }

    .pesanan-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .pesanan-header-card {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .pesanan-id {
      font-size: 18px;
      font-weight: 700;
      color: var(--dark);
    }

    .pesanan-status {
      padding: 6px 15px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      color: white;
    }

    .pesanan-status.process {
      background: var(--icon-orange);
    }

    .pesanan-status.sending {
      background: var(--blue);
    }

    .pesanan-status.done {
      background: var(--icon-teal);
    }

    .pesanan-body {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin-bottom: 15px;
    }

    .pesanan-info-item {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }

    .pesanan-info-item label {
      font-size: 12px;
      color: rgba(0, 0, 0, 0.6);
      font-weight: 500;
    }

    .pesanan-info-item span {
      font-size: 14px;
      color: var(--dark);
      font-weight: 600;
    }

    .pesanan-total {
      font-size: 20px;
      color: var(--secondary);
      font-weight: 700;
    }

    .pesanan-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .btn-pesanan {
      flex: 1;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 1px solid var(--dark);
    }

    .btn-proses {
      background: var(--blue);
      color: white;
    }

    .btn-proses:hover {
      background: #0d1642;
      transform: translateY(-2px);
    }

    .btn-selesai {
      background: var(--icon-teal);
      color: white;
    }

    .btn-selesai:hover {
      background: #00786f;
      transform: translateY(-2px);
    }

    /* PESAN PAGE */
    .pesan-page {
      margin-top: 20px;
    }

    .pesan-header h2 {
      font-size: 32px;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 30px;
    }

    .pesan-container {
      max-width: 100%;
      margin: 0 auto;
    }

    .pesan-card {
      background: var(--light);
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      border-left: 4px solid var(--primary);
    }

    .pesan-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .pesan-card.unread {
      background: linear-gradient(to right, var(--light), white);
      border-left-color: var(--secondary);
    }

    .pesan-header-card {
      display: flex;
      justify-content: space-between;
      align-items: start;
      margin-bottom: 15px;
    }

    .pesan-sender {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .sender-avatar {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      font-weight: 700;
      color: white;
      border: 2px solid var(--dark);
    }

    .sender-info h4 {
      font-size: 16px;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 3px;
    }

    .sender-info p {
      font-size: 12px;
      color: rgba(0, 0, 0, 0.6);
    }

    .pesan-time {
      font-size: 12px;
      color: rgba(0, 0, 0, 0.5);
      font-weight: 500;
    }

    .pesan-content {
      margin-top: 15px;
      padding: 15px;
      background: var(--light);
      border-radius: 8px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      box-shadow: inset 0 0 5.7px rgba(0, 0, 0, 0.15);
    }

    .pesan-subject {
      font-size: 14px;
      font-weight: 600;
      color: var(--secondary);
      margin-bottom: 10px;
    }

    .pesan-text {
      font-size: 14px;
      color: var(--dark);
      line-height: 1.6;
    }

    .pesan-actions {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }

    .btn-balas {
      padding: 8px 20px;
      background: var(--secondary);
      color: white;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 1px solid var(--dark);
    }

    .btn-balas:hover {
      background: #5a2716;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(123, 52, 29, 0.4);
    }

    .btn-hapus-pesan {
      padding: 8px 20px;
      background: #d32f2f;
      color: white;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 1px solid var(--dark);
    }

    .btn-hapus-pesan:hover {
      background: #b71c1c;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(211, 47, 47, 0.4);
    }

    .popup-overlay {
      position: fixed !important;
      inset: 0 !important;
      /* top, right, bottom, left = 0 */
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.55);
      display: none;
      /* disembunyikan default */
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    /* Saat popup aktif, JS menambah class .open */
    .popup-overlay.open,
    .popup-overlay[style*="display: block"] {
      display: flex !important;
    }

    /* Kotak isi popup */
    .popup-content {
      position: relative;
      background-color: #ffcf40;
      padding: 30px 35px;
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
      width: 100%;
      max-width: 420px;
      animation: fadeIn 0.25s ease;
    }

    /* Tombol X */
    .close-popup {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      color: #333;
      cursor: pointer;
      font-weight: bold;
    }

    /* Animasi halus */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }

      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .popup-content h2 {
      font-size: 32px;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 30px;
      text-align: center;
    }

    .popup-content form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .popup-content label {
      display: block;
      font-size: 14px;
      font-weight: 600;
      color: var(--dark);
      margin-bottom: 8px;
    }

    .popup-content input[type="text"],
    .popup-content input[type="number"],
    .popup-content select,
    .popup-content textarea {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 10px;
      font-size: 14px;
      font-family: "Poppins", sans-serif;
      background: var(--light);
      color: var(--dark);
      transition: all 0.3s ease;
    }

    .chat-dropdown {
      position: relative;
      width: 100%;
      cursor: pointer;
      user-select: none;
    }

    .chat-dropdown .selected {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 14px;
      border-radius: 12px;
      background: linear-gradient(180deg,
          rgba(255, 255, 255, 0.06),
          rgba(0, 0, 0, 0.02));
      border: 1px solid rgba(0, 0, 0, 0.08);
      font-size: 14px;
      color: var(--dark);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .chat-dropdown .selected .label {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .chat-dropdown .chev {
      font-size: 14px;
      opacity: 0.8;
      transition: transform 0.18s ease;
    }

    .chat-dropdown.open .chev {
      transform: rotate(180deg);
    }

    .chat-dropdown .options {
      position: absolute;
      left: 0;
      right: 0;
      margin-top: 8px;
      background: var(--primary);
      border-radius: 12px;
      border: 1px solid rgba(0, 0, 0, 0.06);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      z-index: 30;
      max-height: 160px;
      overflow-y: auto;
    }

    /* MINIMAL CSS TAMBAHAN (2) - sembunyikan opsi dropdown default; akan tampil saat .open */
    .chat-dropdown .options {
      display: none;
    }

    .chat-dropdown.open .options {
      display: block;
    }

    .chat-dropdown .option {
      padding: 12px 14px;
      font-size: 14px;
      color: var(--dark);
      cursor: pointer;
      transition: background 0.14s ease;
    }

    .chat-dropdown .option:hover,
    .chat-dropdown .option[aria-selected="true"] {
      background: rgba(0, 0, 0, 0.04);
    }

    .chat-dropdown .options::-webkit-scrollbar {
      width: 8px;
    }

    .chat-dropdown .options::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, 0.12);
      border-radius: 10px;
      border: 2px solid transparent;
      background-clip: padding-box;
    }

    .popup-content textarea {
      width: 100%;
      padding: 12px 16px;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 10px;
      font-size: 14px;
      font-family: "Poppins", sans-serif;
      background: var(--light);
      color: var(--dark);
      transition: all 0.3s ease;
      resize: vertical;
      min-height: 100px;
      max-height: 220px;
    }

    .form-textarea-wrapper label {
      font-size: 14px;
    }

    .form-textarea-wrapper textarea {
      width: 100%;
      padding: 12px 14px;
      border: none;
      resize: vertical;
      min-height: 100px;
      max-height: 220px;
      font-family: "Poppins", sans-serif;
      font-size: 14px;
      color: var(--dark);
      background: transparent;
      outline: none;
      background-color: var(--light);
    }

    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--secondary);
      color: white;
      border: 1px solid var(--dark);
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.24s ease;
      box-shadow: 0 2px 8px rgba(123, 52, 29, 0.28);
      margin-top: 10px;
    }

    .btn-submit:hover {
      background: #5a2716;
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(123, 52, 29, 0.36);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .main-section {
        margin-left: 0;
        padding: 10px;
      }

      .sidebar {
        width: 0;
        overflow: hidden;
      }

      .pembungkusluar {
        gap: 20px;
      }

      .pembungkusluar .produk-item {
        width: 100%;
        max-width: 320px;
      }

      .product-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
      }

      .pesanan-body {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="brand">
        <div class="brand-logo">
          <img src="properties/logo.png" alt="logo" />
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
          <span>@admin</span>
        </div>
        <div class="admin-avatar">
          <img src="properties/logo.png" alt="ava" />
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
            <h3>67 Pesanan</h3>
            <span class="trend">↑ 12% dari bulan kemarin</span>
          </div>
          <div class="stat-icon penjualan">
            <i class="fa-solid fa-chart-line"></i>
          </div>
        </div>

        <div class="stat-card pendapatan">
          <div class="stat-info">
            <p>Pendapatan Bulan Ini</p>
            <h3>Rp. 57.000.000</h3>
            <span class="trend">↑ 1% dari bulan kemarin</span>
          </div>
          <div class="stat-icon pendapatan">
            <i class="fa-solid fa-money-bill-wave"></i>
          </div>
        </div>

        <div class="stat-card pelanggan">
          <div class="stat-info">
            <p>Total Pelanggan Bulan Ini</p>
            <h3>5.700 Pelanggan</h3>
            <span class="trend">↑ 2% dari bulan kemarin</span>
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
        <div class="activity-item done">
          <div class="activity-dot done"></div>
          <div class="activity-details">
            <p>
              Pesanan atas nama <span>Paijo</span> -
              <span>Bakso Campur 2x</span>
            </p>
            <p>Status: <span>Selesai</span></p>
            <p>Tanggal: <span>12 Januari 2025</span></p>
          </div>
        </div>

        <div class="activity-item sending">
          <div class="activity-dot sending"></div>
          <div class="activity-details">
            <p>
              Pesanan atas nama <span>Siti</span> - <span>Bakso Urat 1x</span>
            </p>
            <p>Status: <span>Dikirim</span></p>
            <p>Tanggal: <span>13 Januari 2025</span></p>
          </div>
        </div>

        <div class="activity-item process">
          <div class="activity-dot process"></div>
          <div class="activity-details">
            <p>
              Pesanan atas nama <span>Ahmad</span> -
              <span>Bakso Jumbo 3x</span>
            </p>
            <p>Status: <span>Diproses</span></p>
            <p>Tanggal: <span>14 Januari 2025</span></p>
          </div>
        </div>
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
      <div class="pesanan-container">
        <div class="pesanan-card process">
          <div class="pesanan-header-card">
            <span class="pesanan-id">#ORD-001</span>
            <span class="pesanan-status process">Diproses</span>
          </div>
          <div class="pesanan-body">
            <div class="pesanan-info-item">
              <label>Nama Pelanggan</label><span>Ahmad Wijaya</span>
            </div>
            <div class="pesanan-info-item">
              <label>Nomor Telepon</label><span>0812-3456-7890</span>
            </div>
            <div class="pesanan-info-item">
              <label>Pesanan</label><span>Bakso Campur x2, Es Teh Manis x2</span>
            </div>
            <div class="pesanan-info-item">
              <label>Alamat</label><span>Dine in</span>
            </div>
            <div class="pesanan-info-item">
              <label>Tanggal Pesan</label><span>14 Januari 2025, 10:30</span>
            </div>
            <div class="pesanan-info-item">
              <label>Total Pembayaran</label><span class="pesanan-total">Rp 72.000</span>
            </div>
          </div>
          <div class="pesanan-actions">
            <button class="btn-pesanan btn-proses">
              <i class="fa-solid fa-truck"></i> Kirim Pesanan
            </button>
          </div>
        </div>

        <div class="pesanan-card sending">
          <div class="pesanan-header-card">
            <span class="pesanan-id">#ORD-002</span>
            <span class="pesanan-status sending">Dikirim</span>
          </div>
          <div class="pesanan-body">
            <div class="pesanan-info-item">
              <label>Nama Pelanggan</label><span>Siti Nurhaliza</span>
            </div>
            <div class="pesanan-info-item">
              <label>Nomor Telepon</label><span>0813-9876-5432</span>
            </div>
            <div class="pesanan-info-item">
              <label>Pesanan</label><span>Bakso Urat x1, Bakso Telur x1</span>
            </div>
            <div class="pesanan-info-item">
              <label>Alamat</label><span>Jl. Pahlawan No. 45, Surabaya</span>
            </div>
            <div class="pesanan-info-item">
              <label>Tanggal Pesan</label><span>13 Januari 2025, 14:15</span>
            </div>
            <div class="pesanan-info-item">
              <label>Total Pembayaran</label><span class="pesanan-total">Rp 57.000</span>
            </div>
          </div>
          <div class="pesanan-actions">
            <button class="btn-pesanan btn-selesai">
              <i class="fa-solid fa-check"></i> Selesaikan Pesanan
            </button>
          </div>
        </div>

        <div class="pesanan-card done">
          <div class="pesanan-header-card">
            <span class="pesanan-id">#ORD-003</span>
            <span class="pesanan-status done">Selesai</span>
          </div>
          <div class="pesanan-body">
            <div class="pesanan-info-item">
              <label>Nama Pelanggan</label><span>Budi Santoso</span>
            </div>
            <div class="pesanan-info-item">
              <label>Nomor Telepon</label><span>0856-1234-5678</span>
            </div>
            <div class="pesanan-info-item">
              <label>Pesanan</label><span>Bakso Jumbo x3, Mie Ayam Bakso x1</span>
            </div>
            <div class="pesanan-info-item">
              <label>Alamat</label><span>Jl. Sudirman No. 78, Surabaya</span>
            </div>
            <div class="pesanan-info-item">
              <label>Tanggal Pesan</label><span>12 Januari 2025, 18:45</span>
            </div>
            <div class="pesanan-info-item">
              <label>Total Pembayaran</label><span class="pesanan-total">Rp 132.000</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- PESAN (tetap) -->
    <div class="pesan-page hidden" id="page-pesan">
      <div class="pesan-header">
        <h2>Ulasan Pelanggan</h2>
      </div>
      <div class="pesan-container">
        <div class="pesan-card unread">
          <div class="pesan-header-card">
            <div class="pesan-sender">
              <div class="sender-avatar">F</div>
              <div class="sender-info">
                <h4>fano</h4>
                <p>fanogeymink@email.com</p>
              </div>
            </div>
            <span class="pesan-time">2 jam yang lalu</span>
          </div>
          <div class="pesan-content">
            <div class="pesan-text">Back end besok-besok, besok opoe</div>
          </div>
          <div class="pesan-actions">
            <button class="btn-balas">
              <i class="fa-solid fa-eye"></i> Tandai Dibaca</button><button class="btn-hapus-pesan">
              <i class="fa-solid fa-trash"></i> Hapus
            </button>
          </div>
        </div>

        <div class="pesan-card unread">
          <div class="pesan-header-card">
            <div class="pesan-sender">
              <div class="sender-avatar">SN</div>
              <div class="sender-info">
                <h4>Siti Nurhaliza</h4>
                <p>siti.nurhaliza@email.com</p>
              </div>
            </div>
            <span class="pesan-time">5 jam yang lalu</span>
          </div>
          <div class="pesan-content">
            <div class="pesan-text">
              Pertama kali nyoba Bakso Urat di sini dan langsung jatuh cinta!
              Teksturnya pas banget...
            </div>
          </div>
          <div class="pesan-actions">
            <button class="btn-balas">
              <i class="fa-solid fa-eye"></i> Tandai Dibaca</button><button class="btn-hapus-pesan">
              <i class="fa-solid fa-trash"></i> Hapus
            </button>
          </div>
        </div>
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

  <script>

    // Element utama
    const body = document.body;
    const popup = document.getElementById("popupProduk");
    const popupContent = document.getElementById("popupContent");
    const popupTitle = document.getElementById("popupTitle");
    const closePopupBtn = document.getElementById("closePopup");
    const form = document.getElementById("formProduk");
    const submitButton = document.getElementById("submit");
    const btnTambah = document.querySelector(".btn-tambah");
    const editButtons = document.querySelectorAll(".btn-edit");
    const selectKategori = document.getElementById("kategori");
    const hargaInput = document.getElementById("harga");

    let currentMode = "tambah"; // default mode

    /* ---------- Format angka jadi Rupiah ---------- */
    function formatRupiah(angka) {
      const numberString = angka.replace(/[^0-9]/g, '');
      const number = parseInt(numberString);
      if (isNaN(number)) return '';
      return 'Rp ' + number.toLocaleString('id-ID');
    }

    // Format harga saat user mengetik
    hargaInput.addEventListener("input", function (e) {
      const cursorPos = this.selectionStart;
      const oldLength = this.value.length;

      const formatted = formatRupiah(this.value);
      this.value = formatted;

      const newLength = formatted.length;
      const diff = newLength - oldLength;
      this.setSelectionRange(cursorPos + diff, cursorPos + diff);
    });

    /* ---------- Buka popup (tambah / edit) ---------- */
    function openPopup(mode = "tambah", data = null) {
      currentMode = mode;
      popup.classList.add("open");
      popup.style.display = "block";
      popup.setAttribute("aria-hidden", "false");
      body.classList.add("modal-open");
      body.style.overflow = "hidden";

      const imageInput = document.getElementById('image');
      if (mode === 'tambah') {
        imageInput.required = true;   // wajib saat tambah produk
      } else {
        imageInput.required = false;  // opsional saat edit
      }

      // ubah judul dan tombol
      popupTitle.textContent = mode === "edit" ? "Edit Produk" : "Tambah Produk";
      form.action = mode === "edit" ? "update.php" : "dashboardadmin.php";
      submitButton.name = mode === "edit" ? "update" : "submit";
      submitButton.textContent = mode === "edit" ? "Perbarui Produk" : "Simpan Produk";

      if (mode === "edit" && data) {
        document.getElementById("produkId").value = data.id || "";
        document.getElementById("nama").value = data.nama || "";
        document.getElementById("kategori").value = data.kategori || "";
        document.getElementById("deskripsi").value = data.deskripsi || "";
        document.getElementById("harga").value = data.harga ? formatRupiah(data.harga.toString()) : "";
      } else {
        form.reset();
        document.getElementById("produkId").value = "";
      }
    }

    /* ---------- Tutup popup ---------- */
    function closePopup() {
      popup.classList.remove("open");
      popup.style.display = "none";
      popup.setAttribute("aria-hidden", "true");
      body.classList.remove("modal-open");
      body.style.overflow = "";
      form.reset();

      // Kembalikan ke mode tambah
      popupTitle.textContent = "Tambah Produk";
      form.action = "dashboardadmin.php";
      submitButton.name = "submit";
      submitButton.textContent = "Simpan Produk";
    }

    /* ---------- Event tombol tambah ---------- */
    if (btnTambah) {
      btnTambah.addEventListener("click", (e) => {
        e.stopPropagation();
        openPopup("tambah", null);
      });
    }

    /* ---------- Event tombol edit ---------- */
    editButtons.forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.stopPropagation();
        const card = btn.closest(".produk-item");
        if (!card) return;

        const id = card.querySelector("button.btn-edit").getAttribute("onclick")?.match(/\d+/)?.[0] || "";
        const nama = card.querySelector(".nama h3")?.textContent?.trim() || "";
        const hargaText = card.querySelector(".harga-produk h3")?.textContent?.replace(/[^0-9]/g, '') || "";
        const deskripsi = card.querySelector(".deskripsi p")?.textContent?.trim() || "";
        const kategori = card.querySelector(".judul h4")?.textContent?.trim() || "";

        openPopup("edit", { id, nama, harga: hargaText, deskripsi, kategori });
      });
    });

    /* ---------- Event tutup popup ---------- */
    closePopupBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      closePopup();
    });
    popup.addEventListener("click", (e) => {
      if (e.target === popup) closePopup();
    });
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && popup.classList.contains("open")) closePopup();
    });

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
        navItems.forEach((nav) => nav.classList.remove("active"));
        this.classList.add("active");

        Object.values(pages).forEach((page) => page?.classList.add("hidden"));

        if (pageName === "statistik") {
          pages.statistik.classList.remove("hidden");
          document.querySelector(".activity-card").classList.remove("hidden");
        } else {
          document.querySelector(".activity-card").classList.add("hidden");
          pages[pageName]?.classList.remove("hidden");
        }
      });
    });

    /* ---------- Efek 3D kartu produk ---------- */
    const produkItems = document.querySelectorAll(".produk-item");
    produkItems.forEach((item) => {
      const container = item.querySelector(".container");
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

    /* ---------- Logout ---------- */
    function logout() {
      if (confirm("Yakin ingin logout?")) alert("Logout berhasil!");
    }

  </script>
</body>

</html>