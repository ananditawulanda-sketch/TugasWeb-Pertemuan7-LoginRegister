<?php

require_once 'config.php';
if(isset($_SESSION['user'])){
    header("Location: dashboard.php");
    exit;
}

$errors = [];
$success = "";

$name="";
$email = "";
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === ''){
        $errors[] = " nama wajib diisi.";
    } elseif (strlen($name) < 3) {
        $errors[] ="Nama minimal 3 karakter. ";
    } 

     if ($email === ''){
        $errors[] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] ="Format email tidak valid. ";
    } 
     if ($password === ''){
        $errors[] = "Password wajib diisi.";
    } elseif (strlen($password) < 6) {
        $errors[] ="password minimal 6 karakter. ";
    } 

    $users = getUsers();

    foreach($users as $user ){
            if (
                strtolower ($user['email']) === strtolower($email)){
                $errors[] ="Email sudah terdaftar.";
                break;
                }
    }
    if (empty($errors)){
        $newUser = [
            'id' => uniqid('user_', true),
            'name' => $name,
            'email' => strtolower($email),
            
            'password' => password_hash(
                $password,
                PASSWORD_DEFAULT            ),
                'created_at' => date('Y-m-d H:i:s')];
                $users[] =$newUser;
                if(saveUsers($users))  {
                    $success = "Registrasi berhasil! silakan login,";
                    $name ='';
                    $email ='';

                } else{
                    $errors[] ="Data gagal disimpan.";
                }
                } }
                ?>

                <!DOCTYPE html>
                <html lang="id">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Register - Sistem Login</title>

                    <link rel="stylesheet" href="css/style.css">
                </head>
                <body>
                    <div class="container">
                        <div class="card">
                            <div class="brand">
                                <h1>
                                    Daftar Akun
                                </h1>

                                <p>
                                    Sistem Login/ Register PHP Native
                                </p>
                            </div>

                            <?php if (!empty($errors)):?>
                                <div class="alert error">

                                <strong>registerasi gagal:</strong>

                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                    <li>
                                <?= e($error) ?> 
                                </li>
                                <?php endforeach; ?>
                                </ul>
                                </div>
                                <?php endif; ?>

                            <?php if ($success !== ''):?>
                                <div class="alert success">
                                    <?= e($success) ?>
                                </div>
                                <?php endif; ?>

                                <form  method="POST" action="">
                                    <label for="name">
                                    Nama
                                    </label>

                                    <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="<?= e($name) ?>"
                                    placeholder="Masukkan nama"
                                    required
                                >


                                    <label for="email">
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="<?= e($email) ?>"
                                        placeholder="contoh@email.com"
                                        required
                                    >


                                    <label for="password">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        placeholder="Minimal 6 karakter"
                                        required
                                    >


                                    <button type="submit">
                                        Daftar
                                    </button>
                                </form>

                                <p class="switch">
                                    Sudah Punya Akun 
                                    <a href="login.php">
                                        Login di sini
                                    </a>
                                </p>
                        </div>
                    </div>
                    
                </body>
                </html>