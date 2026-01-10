<?php
include 'koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM ruangan WHERE id='$id'");

header("Location: ruangan.php");
