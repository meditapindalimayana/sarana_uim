<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['nama_gedung'];
    $lokasi = $_POST['lokasi'];
    $ket = $_POST['keterangan'];

    mysqli_query($conn, "INSERT INTO gedung VALUES (
        NULL, '$nama', '$lokasi', '$ket', NOW()
    )");

    header("Location: gedung.php");
}
include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
    <h3 class="page-title">Tambah Gedung</h3>

    <div class="card-dashboard col-md-6">
        <form method="post">
            <div class="mb-3">
                <label>Nama Gedung</label>
                <input type="text" name="nama_gedung" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Lokasi</label>
                <input type="text" name="lokasi" class="form-control">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>

            <button name="simpan" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="gedung.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
