<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM riwayat_perawatan WHERE id='$id'");

header("Location: perawatan.php");
