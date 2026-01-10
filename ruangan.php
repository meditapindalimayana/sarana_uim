<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

$data = mysqli_query($conn, "
    SELECT ruangan.*, gedung.nama_gedung 
    FROM ruangan 
    JOIN gedung ON ruangan.gedung_id = gedung.id
    ORDER BY ruangan.id DESC
");
?>

<div class="main-content">
    <h3 class="page-title">Data Ruangan</h3>

    <a href="ruangan_tambah.php" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Ruangan
    </a>

    <div class="card-dashboard">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Gedung</th>
                    <th>Nama Ruangan</th>
                    <th>Lantai</th>
                    <th>Keterangan</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $r['nama_gedung'] ?></td>
                    <td><?= $r['nama_ruangan'] ?></td>
                    <td><?= $r['lantai'] ?></td>
                    <td><?= $r['keterangan'] ?></td>
                    <td>
                        <a href="ruangan_edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="ruangan_hapus.php?id=<?= $r['id'] ?>" 
                           onclick="return confirm('Hapus ruangan ini?')"
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
