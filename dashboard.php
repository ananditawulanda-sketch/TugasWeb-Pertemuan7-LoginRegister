<?php

require_once 'config.php';
requireLogin();
$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Login</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="dashboard-card">
        <div class="dashboard-header">

        <div>
             <p class="small-title">
                DASHBOARD
             </p>

             <h1>
                Halo,<?= e ($user['name'])?>!👏
             </h1>

             <p>Selamat datang di sistem login/register PHP Native.</p>
        </div>
        <a 
        class="logout"
        href="logout.php"> Logout 
    </a>
        </div>
        <div class="profile-box">
            <h2>
                Data Akun 
            </h2>
            <div class="profile-item">
                <span>
                    Nama
                </span>

                <strong>
                    <?=e($user['name'])?>

                </strong>
            </div>
            <div class="profile-item">
                <span>
                    Email
                </span>

                <strong>
                    <?=e($user['email'])?>

                </strong>
            </div>
        
        </div>

        <div class="info-box">
            <h2>
                Status Login
            </h2>

            <p>  ✓ Kamu berhasil login dan halaman dashboard
                ini terlindungi oleh session.</p>
        </div>
    </div>
</div>
    
</body>
</html>