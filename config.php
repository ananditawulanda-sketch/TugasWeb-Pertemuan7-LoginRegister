<?php
if (session_status () === PHP_SESSION_NONE){
    session_start();

}

define ( 'DATA_FILE', __DIR__.'/data/users.json');

function getUsers(): array
{
    if(!file_exists(DATA_FILE)){
        file_put_contents(DATA_FILE, '[]');

    }
    $json = file_get_contents(DATA_FILE);
    $users = json_decode($json, true);

    return is_array($users) ? $users : [];
}

function
 saveUsers(array $users): bool 
 {
    $json = json_encode(
        $users,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
    );
    return file_put_contents(DATA_FILE,$json, LOCK_EX) !==false;

 }
 function e(string $value): string {
    return htmlspecialchars(
        $value,
        ENT_QUOTES,
        'UTF-8'
    );
 }
 
 function requireLogin(): void 
 {
    if (!isset($_SESSION['user'])){
        header("Location: login.php?error=Silakan login terlebih dahulu.");
        exit;
    }
 }
 ?>