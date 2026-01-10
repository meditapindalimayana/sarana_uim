<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

// Query dashboard
$gedung = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM gedung"));
$ruangan = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM ruangan"));
$aset = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset"));
$rusak_berat = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset WHERE kondisi='rusak berat'"));
?>

<div class="main-content">
    <h3 class="page-title">Dashboard</h3>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card-dashboard">
                <h6>Total Gedung</h6>
                <h2><?= $gedung ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-dashboard">
                <h6>Total Ruangan</h6>
                <h2><?= $ruangan ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-dashboard">
                <h6>Total Aset</h6>
                <h2><?= $aset ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-dashboard">
                <h6>Rusak Berat</h6>
                <h2 class="text-danger"><?= $rusak_berat ?></h2>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
