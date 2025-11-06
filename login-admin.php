<?php
session_start();

 if (isset($_SESSION["login"])) {
    header("Location: login-admin.php");
    exit;
 }


require 'functions.php';

if (isset($_POST["login"])) { 
    
   $username = $_POST["username"];
   $password = $_POST["password"];

   $result = mysqli_query($conn,"SELECT * FROM amin WHERE username = '$username' ");

   if (mysqli_num_rows($result) === 1) {

    $row = mysqli_fetch_assoc($result);
    if(password_verify($password, $row["password"])) {
        $_SESSION["login"] = true;

        $_SESSION["login"] = true;

        header("Location: dashboardadmin.php");
        exit;
    }     
}
  $error = "true";
}

?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(125deg, var(--icon-orange), var(--primary));
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
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

    .kepala {
        background: linear-gradient(195deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2));
        backdrop-filter: blur(20px);
        padding: 40px 30px;
        border-radius: 13px;
        border: solid 1px rgba(3, 3, 3, 0.4);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        box-sizing: border-box;
    }

    .kepala h2 {
        text-align: center;
        margin-bottom: 30px;
        color: rgb(145, 42, 42);
    }

    .kolom {
        position: relative;
        margin-bottom: 20px;
    }

    .kolom input[type="text"],
    button {
        color: rgb(145, 42, 42);
        width: 100%;
        padding: 12px 10px;
        font-size: 16px;
        border: 1px solid #000000;
        border-radius: 8px;
        outline: none;
        box-sizing: border-box;
        background: transparent;
    }

    .kolom input[type="password"] {
        color: rgb(145, 42, 42);
        width: 100%;
        padding: 12px 10px;
        font-size: 16px;
        border: 1px solid #000000;
        border-radius: 8px;
        outline: none;
        box-sizing: border-box;
        background: transparent;
    }

    .kolom input:focus+span,
    .kolom input:valid+span {
        top: -20px;
        left: 0px;
        font-size: 15px;
        color: rgb(145, 42, 42);
        background: transparent;

    }

    .kolom span {
        position: absolute;
        left: 12px;
        top: 12px;
        padding: 0 5px;
        color: rgb(145, 42, 42);
        transition: 0.3s ease;
        pointer-events: none;
    }

    button {
        background-color: rgb(145, 42, 42);
        color: white;
        border: none;
        cursor: pointer;
        transition: background 0.3s;
    }

    button:hover {
        background-color: rgb(223, 58, 58);
    }

    p {
        text-align: center;
        margin-top: 15px;
        color: #ffffff;
    }

    p .login {
        color: #91eef6;
        text-decoration: none;
    }

    .error {
        color: red;
    }
</style>

<body>
    <form action="" method="post">
        <div class="kepala">
            <h2>ADMIN - LOGIN</h2>
            <?php if (isset($error)) : ?>
            <p class="error">Email atau password salah</p>
            <?php endif; ?>
            <div class="kolom">
                <input type="text" name="username" id="username" required />
                <span>username</span>
            </div>
            <div class="kolom">
                <input type="password" name="password" id="password" required />
                <span>password</span>
            </div>
            <div class="kolom">
                <button type="submit" name="login">Masuk</button>
            </div>
    </form>
    </div>
</body>
   
</html>