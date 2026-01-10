<?php
include 'koneksi.php';

$id = $_GET['id'];

// Ambil data aset
$data = mysqli_query($conn, "SELECT * FROM aset WHERE id='$id'");
$a = mysqli_fetch_assoc($data);

// Data relasi
$kategori = mysqli_query($conn, "SELECT * FROM kategori_aset");
$gedung   = mysqli_query($conn, "SELECT * FROM gedung");
$ruangan  = mysqli_query($conn, "SELECT * FROM ruangan");

if(isset($_POST['update'])){
    $nama     = $_POST['nama_aset'];
    $kategori_id = $_POST['kategori_id'];
    $gedung_id   = $_POST['gedung_id'];
    $ruangan_id  = $_POST['ruangan_id'];
    $status   = $_POST['status'];
    $kondisi  = $_POST['kondisi'];
    $ket      = $_POST['keterangan'];

    $gambar_lama = $a['gambar'];
    $gambar_baru = $_FILES['gambar']['name'];

    if($gambar_baru){
        $ext = pathinfo($gambar_baru, PATHINFO_EXTENSION);
        $nama_file = time()."_".$gambar_baru;
        move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/".$nama_file);

        if($gambar_lama && file_exists("upload/".$gambar_lama)){
            unlink("upload/".$gambar_lama);
        }
    } else {
        $nama_file = $gambar_lama;
    }

    mysqli_query($conn, "UPDATE aset SET
        nama_aset='$nama',
        kategori_id='$kategori_id',
        gedung_id='$gedung_id',
        ruangan_id='$ruangan_id',
        gambar='$nama_file',
        status='$status',
        kondisi='$kondisi',
        keterangan='$ket'
        WHERE id='$id'
    ");

    header("Location: aset.php");
}

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
<h3 class="page-title">Edit Aset</h3>

<div class="card-dashboard col-md-8">
<form method="post" enctype="multipart/form-data">

<div class="row">
    <div class="col-md-6">
        <label>Nama Aset</label>
        <input type="text" name="nama_aset" value="<?= $a['nama_aset'] ?>" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control">
            <?php while($k=mysqli_fetch_assoc($kategori)): ?>
            <option value="<?= $k['id'] ?>"
                <?= $k['id']==$a['kategori_id']?'selected':'' ?>>
                <?= $k['nama_kategori'] ?>
            </option>
            <?php endwhile ?>
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label>Gedung</label>
        <select name="gedung_id" class="form-control">
            <?php while($g=mysqli_fetch_assoc($gedung)): ?>
            <option value="<?= $g['id'] ?>"
                <?= $g['id']==$a['gedung_id']?'selected':'' ?>>
                <?= $g['nama_gedung'] ?>
            </option>
            <?php endwhile ?>
        </select>
    </div>

    <div class="col-md-6">
        <label>Ruangan</label>
        <select name="ruangan_id" class="form-control">
            <?php while($r=mysqli_fetch_assoc($ruangan)): ?>
            <option value="<?= $r['id'] ?>"
                <?= $r['id']==$a['ruangan_id']?'selected':'' ?>>
                <?= $r['nama_ruangan'] ?>
            </option>
            <?php endwhile ?>
        </select>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="aktif" <?= $a['status']=='aktif'?'selected':'' ?>>Aktif</option>
            <option value="tidak aktif" <?= $a['status']=='tidak aktif'?'selected':'' ?>>Tidak Aktif</option>
        </select>
    </div>

    <div class="col-md-6">
        <label>Kondisi</label>
        <select name="kondisi" class="form-control">
            <option value="baik" <?= $a['kondisi']=='baik'?'selected':'' ?>>Baik</option>
            <option value="rusak ringan" <?= $a['kondisi']=='rusak ringan'?'selected':'' ?>>Rusak Ringan</option>
            <option value="rusak berat" <?= $a['kondisi']=='rusak berat'?'selected':'' ?>>Rusak Berat</option>
        </select>
    </div>
</div>

<div class="mt-3">
    <label>Gambar Saat Ini</label><br>
    <?php if($a['gambar']): ?>
        <img src="upload/<?= $a['gambar'] ?>" width="150" class="img-thumbnail mb-2">
    <?php else: ?>
        <p class="text-muted">Tidak ada gambar</p>
    <?php endif ?>
</div>

<div class="mt-2">
    <label>Ganti Gambar (opsional)</label>
    <input type="file" name="gambar" class="form-control">
</div>

<div class="mt-3">
    <label>Keterangan</label>
    <textarea name="keterangan" class="form-control"><?= $a['keterangan'] ?></textarea>
</div>

<button name="update" class="btn btn-primary mt-4">
    <i class="bi bi-save"></i> Update
</button>
<a href="aset.php" class="btn btn-secondary mt-4">Kembali</a>

</form>
</div>
</div>

<?php include 'layout/footer.php'; ?>
