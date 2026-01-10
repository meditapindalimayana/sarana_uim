<?php
include 'koneksi.php';

if(isset($_POST['simpan'])){
    $nama = $_POST['nama_aset'];
    $kategori = $_POST['kategori_id'];
    $gedung = $_POST['gedung_id'];
    $ruangan = $_POST['ruangan_id'];
    $status = $_POST['status'];
    $kondisi = $_POST['kondisi'];
    $ket = $_POST['keterangan'];

    $gambar = $_FILES['gambar']['name'];
    if($gambar){
        move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/".$gambar);
    }

    mysqli_query($conn, "INSERT INTO aset VALUES(
        NULL,'$nama','$kategori','$gedung','$ruangan',
        '$gambar','$status','$kondisi','$ket',NOW()
    )");

    header("Location: aset.php");
}

$kategori = mysqli_query($conn, "SELECT * FROM kategori_aset");
$gedung   = mysqli_query($conn, "SELECT * FROM gedung");
$ruangan  = mysqli_query($conn, "SELECT * FROM ruangan");

include 'layout/header.php';
include 'layout/sidebar.php';
?>

<div class="main-content">
<h3 class="page-title">Tambah Aset</h3>

<div class="card-dashboard col-md-7">
<form method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Nama Aset</label>
        <input type="text" name="nama_aset" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Kategori</label>
        <select name="kategori_id" class="form-control" required>
            <option value="">-- Pilih --</option>
            <?php while($k=mysqli_fetch_assoc($kategori)): ?>
                <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
            <?php endwhile ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label>Gedung</label>
            <select name="gedung_id" class="form-control">
                <?php while($g=mysqli_fetch_assoc($gedung)): ?>
                    <option value="<?= $g['id'] ?>"><?= $g['nama_gedung'] ?></option>
                <?php endwhile ?>
            </select>
        </div>

        <div class="col-md-6">
            <label>Ruangan</label>
            <select name="ruangan_id" class="form-control">
                <?php while($r=mysqli_fetch_assoc($ruangan)): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['nama_ruangan'] ?></option>
                <?php endwhile ?>
            </select>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-6">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
            </select>
        </div>

        <div class="col-md-6">
            <label>Kondisi</label>
            <select name="kondisi" class="form-control">
                <option value="baik">Baik</option>
                <option value="rusak ringan">Rusak Ringan</option>
                <option value="rusak berat">Rusak Berat</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control">
    </div>

    <div class="mt-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control"></textarea>
    </div>

    <button name="simpan" class="btn btn-success mt-3">
        <i class="bi bi-save"></i> Simpan
    </button>
    <a href="aset.php" class="btn btn-secondary mt-3">Kembali</a>

</form>
</div>
</div>

<?php include 'layout/footer.php'; ?>