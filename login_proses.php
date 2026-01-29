<?php
session_start();
include 'koneksi.php';

$MAX_ATTEMPT = 5;
$BLOCK_TIME = 300; // 5 menit

// Cek apakah masih diblokir
if(isset($_SESSION['blocked_time'])){
    $selisih = time() - $_SESSION['blocked_time'];

    if($selisih < $BLOCK_TIME){
        header("Location: login.php?blocked=1");
        exit;
    } else {
        // Reset setelah waktu habis
        unset($_SESSION['attempt']);
        unset($_SESSION['blocked_time']);
    }
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = md5($_POST['password']); // sesuai database kamu

$query = mysqli_query($conn, "
    SELECT * FROM admin 
    WHERE username='$username' 
    AND password='$password'
");

$data = mysqli_fetch_assoc($query);

if($data){
    // Login berhasil
    unset($_SESSION['attempt']);
    unset($_SESSION['blocked_time']);

    $_SESSION['login'] = true;
    $_SESSION['id'] = $data['id'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['username'] = $data['username'];

    header("Location: index.php");
    exit;

} else {
    // Login gagal
    $_SESSION['attempt'] = ($_SESSION['attempt'] ?? 0) + 1;

    if($_SESSION['attempt'] >= $MAX_ATTEMPT){
        $_SESSION['blocked_time'] = time();
        header("Location: login.php?blocked=1");
        exit;
    }

    header("Location: login.php?error=1");
    exit;
}
