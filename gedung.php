<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

$data = mysqli_query($conn, "SELECT * FROM gedung ORDER BY id DESC");
?>

<div class="main-content">
    <h3 class="page-title">Data Gedung</h3>

    <a href="gedung_tambah.php" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Gedung
    </a>

    <div class="card-dashboard">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Gedung</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['nama_gedung'] ?></td>
                    <td><?= $row['lokasi'] ?></td>
                    <td><?= $row['keterangan'] ?></td>
                    <td>
                        <a href="gedung_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="gedung_hapus.php?id=<?= $row['id'] ?>" 
                           onclick="return confirm('Hapus gedung ini?')"
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
