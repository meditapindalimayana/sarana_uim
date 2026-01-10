<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

$data = mysqli_query($conn, "
    SELECT a.*, 
           k.nama_kategori,
           g.nama_gedung,
           r.nama_ruangan
    FROM aset a
    JOIN kategori_aset k ON a.kategori_id = k.id
    JOIN gedung g ON a.gedung_id = g.id
    JOIN ruangan r ON a.ruangan_id = r.id
    ORDER BY a.id DESC
");
?>

<div class="main-content">
    <h3 class="page-title">Data Aset</h3>

    <a href="aset_tambah.php" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Aset
    </a>

    <div class="card-dashboard">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Aset</th>
                    <th>Kategori</th>
                    <th>Gedung</th>
                    <th>Ruangan</th>
                    <th>Status</th>
                    <th>Kondisi</th>
                    <th>Gambar</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($a=mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $a['nama_aset'] ?></td>
                    <td><?= $a['nama_kategori'] ?></td>
                    <td><?= $a['nama_gedung'] ?></td>
                    <td><?= $a['nama_ruangan'] ?></td>
                    <td>
                        <span class="badge bg-<?= $a['status']=='aktif'?'success':'secondary' ?>">
                            <?= $a['status'] ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-<?=
                            $a['kondisi']=='baik'?'success':
                            ($a['kondisi']=='rusak ringan'?'warning':'danger')
                        ?>">
                            <?= $a['kondisi'] ?>
                        </span>
                    </td>
                    <td>
                        <?php if($a['gambar']): ?>
                            <img src="upload/<?= $a['gambar'] ?>" width="50">
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="aset_edit.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="aset_hapus.php?id=<?= $a['id'] ?>" 
                           onclick="return confirm('Hapus aset ini?')" 
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
