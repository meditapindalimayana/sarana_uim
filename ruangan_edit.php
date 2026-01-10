<?php
include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM ruangan WHERE id='$id'");
$r = mysqli_fetch_assoc($data);

$gedung = mysqli_query($conn, "SELECT * FROM gedung");

if(isset($_POST['update'])){
    mysqli_query($conn, "UPDATE ruangan SET
        gedung_id='$_POST[gedung_id]',
        nama_ruangan='$_POST[nama_ruangan]',
        lantai='$_POST[lantai]',
        keterangan='$_POST[keterangan]'
        WHERE id='$id'
    ");

    header("Location: ruangan.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
    <h3 class="page-title">Edit Ruangan</h3>

    <div class="card-dashboard col-md-6">
        <form method="post">
            <div class="mb-3">
                <label>Gedung</label>
                <select name="gedung_id" class="form-select">
                    <?php while($g=mysqli_fetch_assoc($gedung)): ?>
                        <option value="<?= $g['id'] ?>" 
                            <?= $g['id']==$r['gedung_id']?'selected':'' ?>>
                            <?= $g['nama_gedung'] ?>
                        </option>
                    <?php endwhile ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Nama Ruangan</label>
                <input type="text" name="nama_ruangan" value="<?= $r['nama_ruangan'] ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label>Lantai</label>
                <input type="text" name="lantai" value="<?= $r['lantai'] ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"><?= $r['keterangan'] ?></textarea>
            </div>

            <button name="update" class="btn btn-primary">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="ruangan.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
