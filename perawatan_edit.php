<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM riwayat_perawatan WHERE id='$id'");
$p = mysqli_fetch_assoc($data);

$aset = mysqli_query($conn, "SELECT * FROM aset");

if(isset($_POST['update'])){
    mysqli_query($conn, "UPDATE riwayat_perawatan SET
        aset_id='$_POST[aset_id]',
        tanggal='$_POST[tanggal]',
        jenis_perawatan='$_POST[jenis_perawatan]',
        keterangan='$_POST[keterangan]'
        WHERE id='$id'
    ");

    header("Location: perawatan.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
<h3 class="page-title">Edit Riwayat Perawatan</h3>

<div class="card-dashboard col-md-6">
<form method="post">

    <div class="mb-3">
        <label>Aset</label>
        <select name="aset_id" class="form-control">
            <?php while($a=mysqli_fetch_assoc($aset)): ?>
                <option value="<?= $a['id'] ?>"
                    <?= $a['id']==$p['aset_id']?'selected':'' ?>>
                    <?= $a['nama_aset'] ?>
                </option>
            <?php endwhile ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?= $p['tanggal'] ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Jenis Perawatan</label>
        <input type="text" name="jenis_perawatan" value="<?= $p['jenis_perawatan'] ?>" class="form-control">
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control"><?= $p['keterangan'] ?></textarea>
    </div>

    <button name="update" class="btn btn-primary">
        <i class="bi bi-save"></i> Update
    </button>
    <a href="perawatan.php" class="btn btn-secondary">Kembali</a>

</form>
</div>
</div>

<?php include 'layout/footer.php'; ?>
