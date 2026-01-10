<?php
include 'koneksi.php';

$gedung = mysqli_query($conn, "SELECT * FROM gedung");

if(isset($_POST['simpan'])){
    mysqli_query($conn, "INSERT INTO ruangan VALUES(
        NULL,
        '$_POST[gedung_id]',
        '$_POST[nama_ruangan]',
        '$_POST[lantai]',
        '$_POST[keterangan]',
        NOW()
    )");

    header("Location: ruangan.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
    <h3 class="page-title">Tambah Ruangan</h3>

    <div class="card-dashboard col-md-6">
        <form method="post">
            <div class="mb-3">
                <label>Gedung</label>
                <select name="gedung_id" class="form-select" required>
                    <option value="">-- Pilih Gedung --</option>
                    <?php while($g=mysqli_fetch_assoc($gedung)): ?>
                        <option value="<?= $g['id'] ?>"><?= $g['nama_gedung'] ?></option>
                    <?php endwhile ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Nama Ruangan</label>
                <input type="text" name="nama_ruangan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Lantai</label>
                <input type="text" name="lantai" class="form-control">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>

            <button name="simpan" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan
            </button>
            <a href="ruangan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
