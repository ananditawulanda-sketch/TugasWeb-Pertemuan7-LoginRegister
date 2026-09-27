<?php

require_once 'config.php';

if(isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

$error =$_GET['error'] ?? '';
$success =$_GET['success'] ?? '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === ''){
        $error = "Email dan password wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error ="Format email tidak valid. ";
    } else {
        $users = getUsers();

        $loginSuccess = false;
        foreach ($users as $user) {
            if (
                strtolower ($user['email']) === strtolower($email)
                &&
                password_verify(
                    $password,
                    $user['password']
                )
            ) {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'id' => $user['id'],                    
                    'name' => $user['name'],                    
                    'email' => $user['email']                    
                ];
                $loginSuccess = true;
                
                break;

            }
        }

        if ($loginSuccess) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "email atau password salah.";

        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Login</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="brand">
                <h1> 
                    Login
                </h1>

                <p>
                    Selamat datang kembali
                </p>

            </div>
            <?php if ($error !==''): ?>
                <div class="alert error">

                <?= e($error) ?>
                </div>
                <?php endif; ?>

            <?php if ($success !==''): ?>
                <div class="alert success">

                <?= e($success) ?>
                </div>
                <?php endif; ?>
                <form  method="POST" action="">
                    <label for="email">Email</label>
                <input type="email"
                id="email"
                name="email"
                placeholder="Masukkan email"
                required
                >
                <label for="password">Password</label>
                <input type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
                >

                <button type="submit">
                    Login
                </button>
                </form>

                <p class="switch">
                    Belum punya akun?
                    <a href="register.php"> Daftar di sini</a>
            </p>
                
        </div>
    </div>
    
</body>
</html>