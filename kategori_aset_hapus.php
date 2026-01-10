<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM kategori_aset WHERE id='$id'");

header("Location: kategori_aset.php");
