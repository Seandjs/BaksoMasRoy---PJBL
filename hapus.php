<?php
require 'functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM produk WHERE id = $id";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
                alert('Produk berhasil dihapus');
                document.location.href = 'dashboardadmin.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus produk');
                document.location.href = 'dashboardadmin.php';
              </script>";
    }
} else {
    header('Location: dashboardadmin.php');
    exit;
}
?>