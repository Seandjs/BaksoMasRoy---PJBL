<?php
session_start();
require 'functions.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['id'];

$userQuery = mysqli_query($conn, "SELECT * FROM user WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($userQuery);

if (!$user) {
    die("User tidak ditemukan.");
}

$fullname = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$current = $_POST['current_password'] ?? '';
$newpass = $_POST['new_password'] ?? '';

if ($newpass !== '') {

    if (!password_verify($current, $user['password'])) {
        echo "<script>alert('Password lama salah!');window.location='userprofile.php';</script>";
        exit;
    }

    $hashed_pass = password_hash($newpass, PASSWORD_DEFAULT);

    $query = "UPDATE user SET 
                username = '$fullname',
                email = '$email',
                password = '$hashed_pass'
              WHERE id = '$user_id'";

} else {

    $query = "UPDATE user SET 
                username = '$fullname',
                email = '$email'
              WHERE id = '$user_id'";
}

if (mysqli_query($conn, $query)) {

    $_SESSION['username'] = $fullname;
    $_SESSION['email'] = $email;

    echo "<script>alert('Profil berhasil diperbarui!');window.location='userprofile.php';</script>";
    exit;

} else {
    die("SQL ERROR: " . mysqli_error($conn));
}
?>