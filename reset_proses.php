<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// cek username
$cek = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username'");
if(mysqli_num_rows($cek) == 0){
    header("Location: reset_password.php?error=1");
    exit;
}

// update password
mysqli_query($koneksi, "
    UPDATE pengguna 
    SET password='$password' 
    WHERE username='$username'
");

header("Location: reset_password.php?success=1");
exit;
