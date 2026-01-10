<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

$data = mysqli_query($conn, "SELECT * FROM kategori_aset ORDER BY id DESC");
?>

<div class="main-content">
    <h3 class="page-title">Kategori Aset</h3>

    <a href="kategori_aset_tambah.php" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Kategori
    </a>

    <div class="card-dashboard">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Tanggal Dibuat</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($k=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $k['nama_kategori'] ?></td>
                    <td><?= date('d-m-Y', strtotime($k['created_at'])) ?></td>
                    <td>
                        <a href="kategori_aset_edit.php?id=<?= $k['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="kategori_aset_hapus.php?id=<?= $k['id'] ?>"
                           onclick="return confirm('Hapus kategori ini?')"
                           class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
