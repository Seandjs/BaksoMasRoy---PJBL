<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    <link rel="icon" type="image/png" href="css/properties/logo.png" />
    <style>
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .decorations {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            animation: float-decoration 6s ease-in-out infinite;
        }

        .circle1 {
            width: 100px;
            height: 100px;
            background: var(--icon-orange-light);
            opacity: 0.3;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle2 {
            width: 150px;
            height: 150px;
            background: var(--icon-teal-light);
            opacity: 0.3;
            top: 60%;
            right: 15%;
            animation-delay: 1s;
        }

        .circle3 {
            width: 80px;
            height: 80px;
            background: var(--primary);
            opacity: 0.4;
            bottom: 20%;
            left: 20%;
            animation-delay: 2s;
        }

        .circle4 {
            width: 120px;
            height: 120px;
            background: var(--icon-brown-light);
            opacity: 0.3;
            top: 30%;
            right: 25%;
            animation-delay: 1.5s;
        }

        @keyframes float-decoration {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-30px) scale(1.1);
            }
        }

        .container {
            text-align: center;
            color: var(--secondary);
            z-index: 10;
            padding: 20px;
            position: relative;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(123, 52, 29, 0.2);
            max-width: 700px;
            border: 3px solid var(--primary);
        }

        .error-code {
            font-size: 180px;
            font-weight: bold;
            background: linear-gradient(135deg, var(--primary) 0%, var(--icon-orange) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: pulse 2s ease-in-out infinite;
            position: relative;
            display: inline-block;
            text-shadow: 0 5px 15px rgba(251, 210, 68, 0.3);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .icon-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
            animation: bounce 2s ease-in-out infinite;
        }

        .icon {
            font-size: 50px;
            animation: spin 4s linear infinite;
        }

        .icon:nth-child(1) {
            animation-delay: 0s;
        }

        .icon:nth-child(2) {
            animation-delay: 0.3s;
        }

        .icon:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes spin {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        h1 {
            font-size: 48px;
            margin: 20px 0;
            color: var(--secondary);
            font-weight: bold;
        }

        p {
            font-size: 20px;
            margin: 15px 0;
            color: var(--secondary);
            opacity: 0.8;
        }

        .btn-home {
            display: inline-block;
            margin-top: 30px;
            padding: 15px 40px;
            background: var(--primary);
            border: 3px solid var(--secondary);
            border-radius: 50px;
            color: var(--secondary);
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(123, 52, 29, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-home::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: var(--icon-orange);
            transition: width 0.6s, height 0.6s, top 0.6s, left 0.6s;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        .btn-home:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(123, 52, 29, 0.4);
            color: var(--background);
        }

        .lines {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
        }

        .line {
            position: absolute;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, var(--primary), transparent);
            opacity: 0.2;
            animation: line-move 3s linear infinite;
        }

        .line:nth-child(1) {
            left: 20%;
            animation-delay: 0s;
        }

        .line:nth-child(2) {
            left: 50%;
            animation-delay: 0.5s;
        }

        .line:nth-child(3) {
            left: 80%;
            animation-delay: 1s;
        }

        @keyframes line-move {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(100%);
            }
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 120px;
            }

            h1 {
                font-size: 32px;
            }

            p {
                font-size: 16px;
            }

            .icon {
                font-size: 40px;
            }

            .container {
                margin: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>

    <div class="decorations">
        <div class="circle circle1"></div>
        <div class="circle circle2"></div>
        <div class="circle circle3"></div>
        <div class="circle circle4"></div>
    </div>

    <div class="container">
        <div class="error-code">404</div>
        <div class="icon-row">
            <span class="icon">🔍</span>
            <span class="icon">📁</span>
            <span class="icon">❌</span>
        </div>
        <h1>Oops! Halaman Tidak Ditemukan</h1>
        <p>Sepertinya halaman yang kamu cari tidak ada...</p>
        <p>Mungkin sudah dipindahkan atau dihapus.</p>
        <a href="index.php" class="btn-home">Kembali ke Beranda</a>
    </div>

    <script>
        const decorations = document.querySelector('.decorations');
        const colors = ['var(--icon-orange-light)', 'var(--icon-teal-light)', 'var(--primary)', 'var(--icon-brown-light)'];

        for (let i = 0; i < 5; i++) {
            const circle = document.createElement('div');
            circle.className = 'circle';
            circle.style.width = Math.random() * 60 + 40 + 'px';
            circle.style.height = circle.style.width;
            circle.style.background = colors[Math.floor(Math.random() * colors.length)];
            circle.style.opacity = '0.2';
            circle.style.left = Math.random() * 100 + '%';
            circle.style.top = Math.random() * 100 + '%';
            circle.style.animationDelay = Math.random() * 3 + 's';
            decorations.appendChild(circle);
        }
    </script>
</body>

</html>