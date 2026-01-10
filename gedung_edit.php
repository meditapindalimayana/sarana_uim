<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM gedung WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){
    $nama = $_POST['nama_gedung'];
    $lokasi = $_POST['lokasi'];
    $ket = $_POST['keterangan'];

    mysqli_query($conn, "UPDATE gedung SET
        nama_gedung='$nama',
        lokasi='$lokasi',
        keterangan='$ket'
        WHERE id='$id'
    ");

    header("Location: gedung.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
    <h3 class="page-title">Edit Gedung</h3>

    <div class="card-dashboard col-md-6">
        <form method="post">
            <div class="mb-3">
                <label>Nama Gedung</label>
                <input type="text" name="nama_gedung" value="<?= $row['nama_gedung'] ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="lokasi" value="<?= $row['lokasi'] ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"><?= $row['keterangan'] ?></textarea>
            </div>

            <button name="update" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="gedung.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
