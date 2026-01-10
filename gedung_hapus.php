<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM gedung WHERE id='$id'");

header("Location: gedung.php");
