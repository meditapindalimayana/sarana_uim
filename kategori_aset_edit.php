<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM kategori_aset WHERE id='$id'");
$k = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){
    mysqli_query($conn, "UPDATE kategori_aset SET
        nama_kategori='$_POST[nama_kategori]'
        WHERE id='$id'
    ");

    header("Location: kategori_aset.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
<h3 class="page-title">Edit Kategori Aset</h3>

<div class="card-dashboard col-md-5">
<form method="post">

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" value="<?= $k['nama_kategori'] ?>" class="form-control">
    </div>

    <button name="update" class="btn btn-primary">
        <i class="bi bi-save"></i> Update
    </button>
    <a href="kategori_aset.php" class="btn btn-secondary">Kembali</a>

</form>
</div>
</div>

<?php include 'layout/footer.php'; ?>
