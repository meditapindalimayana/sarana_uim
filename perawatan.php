<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

$data = mysqli_query($conn, "
    SELECT p.*, a.nama_aset
    FROM riwayat_perawatan p
    JOIN aset a ON p.aset_id = a.id
    ORDER BY p.tanggal DESC
");
?>

<div class="main-content">
    <h3 class="page-title">Riwayat Perawatan Aset</h3>

    <a href="perawatan_tambah.php" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Perawatan
    </a>

    <div class="card-dashboard">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Tanggal</th>
                    <th>Jenis Perawatan</th>
                    <th>Keterangan</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($p=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p['nama_aset'] ?></td>
                    <td><?= date('d-m-Y', strtotime($p['tanggal'])) ?></td>
                    <td><?= $p['jenis_perawatan'] ?></td>
                    <td><?= $p['keterangan'] ?></td>
                    <td>
                        <a href="perawatan_edit.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="perawatan_hapus.php?id=<?= $p['id'] ?>"
                           onclick="return confirm('Hapus data perawatan ini?')"
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
