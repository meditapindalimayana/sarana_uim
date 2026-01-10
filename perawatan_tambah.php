<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    mysqli_query($conn, "INSERT INTO riwayat_perawatan VALUES(
        NULL,
        '$_POST[aset_id]',
        '$_POST[tanggal]',
        '$_POST[jenis_perawatan]',
        '$_POST[keterangan]',
        NOW()
    )");

    header("Location: perawatan.php");
}

$aset = mysqli_query($conn, "SELECT * FROM aset");

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
<h3 class="page-title">Tambah Riwayat Perawatan</h3>

<div class="card-dashboard col-md-6">
<form method="post">

    <div class="mb-3">
        <label>Aset</label>
        <select name="aset_id" class="form-control" required>
            <option value="">-- Pilih Aset --</option>
            <?php while($a=mysqli_fetch_assoc($aset)): ?>
                <option value="<?= $a['id'] ?>">
                    <?= $a['nama_aset'] ?>
                </option>
            <?php endwhile ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Tanggal</label>
        <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Jenis Perawatan</label>
        <input type="text" name="jenis_perawatan" class="form-control" placeholder="Servis, Perbaikan, Pengecekan" required>
    </div>

    <div class="mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>

    <button name="simpan" class="btn btn-success">
        <i class="bi bi-save"></i> Simpan
    </button>
    <a href="perawatan.php" class="btn btn-secondary">Kembali</a>

</form>
</div>
</div>

<?php include 'layout/footer.php'; ?>
