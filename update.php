<?php
require 'functions.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $harga = preg_replace('/[^0-9]/', '', $_POST['harga']);

    if (!empty(($_FILES['image']['name']))) {
        $fileName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];
        $folder = "uploads/";

        $path = $folder . basename($fileName);
        move_uploaded_file($tmpName, $path);

        $stmt = mysqli_prepare($conn, "UPDATE produk SET nama=?, kategori=?, deskripsi=?, harga=?, image=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssisi', $nama, $kategori, $deskripsi, $harga, $path, $id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE produk SET nama=?, kategori=?, deskripsi=?, harga=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, 'sssii', $nama, $kategori, $deskripsi, $harga, $id);
    }

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo "<script>
            alert('Produk berhasil diperbarui');
            document.location.href='dashboardadmin.php';
          </script>";
    } else {
        echo "<script>
            alert('Tidak ada perubahan data');
            document.location.href='dashboardadmin.php';
          </script>";
    }

}














































?>