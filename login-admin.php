<?php
session_start();

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

if (isset($_SESSION["login"])) {
    header("Location: login-admin.php");
    exit;
}


require 'functions.php';

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM amin WHERE username = '$username' ");

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
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
    <title>Login - Admin</title>
    <link rel="icon" type="image/png" href="css/properties/logo.png" />
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        border: none;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        height: 100vh;
        background: linear-gradient(135deg, #fbd244 0%, #ffcc33 100%);
        overflow: hidden;
        position: relative;
    }

    body::before,
    body::after {
        content: '';
        position: absolute;
        background: rgba(255, 255, 255, 0.15);
        transform: rotate(-25deg);
        z-index: 0;
    }

    body::before {
        width: 300px;
        height: 150%;
        top: -25%;
        right: 15%;
    }

    body::after {
        width: 200px;
        height: 150%;
        top: -25%;
        right: 5%;
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

    #container {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 0;
        height: 100vh;
        position: relative;
        z-index: 1;
    }

    .left {
        background-image: url(css/properties/outletmer.png);
        background-size: cover;
        background-position: center;
        height: 100vh;
        width: 50%;
        border-radius: 0 20px 20px 0;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.2);
    }

    .left::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.15);
        pointer-events: none;
    }

    .right {
        height: 100vh;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .right::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 200px;
        background: repeating-linear-gradient(-45deg,
                rgba(255, 255, 255, 0.3),
                rgba(255, 255, 255, 0.3) 15px,
                transparent 15px,
                transparent 30px);
        top: 10%;
        right: 8%;
        border-radius: 20px;
        z-index: 0;
    }

    .right::after {
        content: '';
        position: absolute;
        width: 120px;
        height: 150px;
        background: repeating-linear-gradient(-45deg,
                rgba(255, 255, 255, 0.2),
                rgba(255, 255, 255, 0.2) 15px,
                transparent 15px,
                transparent 30px);
        bottom: 12%;
        left: 5%;
        border-radius: 20px;
        z-index: 0;
    }

    .right form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 15px;
        background: rgba(255, 221, 103, 0.85);
        padding: 50px 45px;
        border-radius: 25px;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(10px);
        width: 420px;
        position: relative;
        z-index: 2;
        animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .right form::before {
        content: '';
        position: absolute;
        width: 80px;
        height: 80px;
        top: 15px;
        left: 15px;
        background: repeating-linear-gradient(-45deg,
                rgba(255, 255, 255, 0.4),
                rgba(255, 255, 255, 0.4) 8px,
                transparent 8px,
                transparent 16px);
        border-radius: 15px;
        pointer-events: none;
    }

    .right form::after {
        content: '';
        position: absolute;
        rotate: 90deg;
        width: 80px;
        height: 80px;
        bottom: 15px;
        right: 15px;
        background: repeating-linear-gradient(45deg,
                rgba(255, 255, 255, 0.4),
                rgba(255, 255, 255, 0.4) 8px,
                transparent 8px,
                transparent 16px);
        border-radius: 15px;
        pointer-events: none;
    }

    .right form .kepala h2 {
        color: var(--dark);
        font-size: 32px;
        text-align: center;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 25px;
        text-transform: uppercase;
        position: relative;
        z-index: 1;
    }

    .kolom {
        margin-top: 8px;
        position: relative;
        margin-bottom: 8px;
        width: 100%;
        z-index: 1;
    }

    .kolom input[type="text"],
    .kolom input[type="password"] {
        color: var(--dark);
        width: 100%;
        padding: 14px 45px 14px 20px;
        font-size: 15px;
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 50px;
        outline: none;
        box-sizing: border-box;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .kolom input[type="text"]:focus,
    .kolom input[type="password"]:focus {
        background: #ffffff;
        border-color: rgba(0, 0, 0, 0.3);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .kolom input:focus+span,
    .kolom input:valid+span {
        top: -10px;
        left: 20px;
        font-size: 12px;
        color: var(--dark);
        background: var(--primary);
        padding: 2px 12px;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .kolom span {
        position: absolute;
        left: 22px;
        top: 14px;
        padding: 0 5px;
        color: #666;
        transition: all 0.3s ease;
        pointer-events: none;
        font-size: 15px;
        font-weight: 400;
    }

    form {
        position: static;
        transform: none;
    }

    button {
        display: block;
        padding: 14px 50px;
        background: var(--secondary);
        text-align: center;
        justify-content: center;
        border-radius: 50px;
        color: #ffffff;
        align-items: center;
        cursor: pointer;
        font-size: 15px;
        margin: 15px auto 0;
        width: auto;
        min-width: 180px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 20px rgba(123, 52, 29, 0.35);
        position: relative;
        overflow: hidden;
        z-index: 1;
        border: 2px solid var(--secondary);
    }

    button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        transition: left 0.5s;
    }

    button:hover::before {
        left: 100%;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(123, 52, 29, 0.45);
        background: #5a2817;
    }

    button:active {
        transform: translateY(0);
        box-shadow: 0 4px 15px rgba(123, 52, 29, 0.35);
    }

    @media (max-width: 1024px) {
        #container {
            flex-direction: column;
        }

        .left {
            width: 100%;
            height: 35vh;
        }

        .right {
            width: 100%;
            height: 65vh;
        }

        .right form {
            width: 90%;
            max-width: 400px;
            padding: 40px 35px;
        }

        .right::before,
        .right::after {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .right form .kepala h2 {
            font-size: 26px;
        }

        .right form {
            padding: 35px 30px;
        }

        button {
            font-size: 14px;
            padding: 12px 40px;
            min-width: 160px;
        }
    }
</style>

<body>

    <section class="container" id="container">

        <div class="left">
            <div class="bg"></div>
        </div>

        <div class="right">
            <form action="" method="post">
                <div class="kepala">
                    <h2>ADMIN - LOGIN</h2>
                    <?php if (isset($error)): ?>
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
                </div>
            </form>
        </div>

    </section>
</body>

</html>