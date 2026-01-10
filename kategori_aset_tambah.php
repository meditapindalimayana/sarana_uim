<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    mysqli_query($conn, "INSERT INTO kategori_aset VALUES(
        NULL,
        '$_POST[nama_kategori]',
        NOW()
    )");

    header("Location: kategori_aset.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
<h3 class="page-title">Tambah Kategori Aset</h3>

<div class="card-dashboard col-md-5">
<form method="post">

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" required>
    </div>

    <button name="simpan" class="btn btn-success">
        <i class="bi bi-save"></i> Simpan
    </button>
    <a href="kategori_aset.php" class="btn btn-secondary">Kembali</a>

</form>
</div>
</div>

<?php include 'layout/footer.php'; ?>
