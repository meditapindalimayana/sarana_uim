<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

// Filter dengan sanitasi
$filter_kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';
$filter_kondisi = isset($_GET['kondisi']) ? mysqli_real_escape_string($conn, $_GET['kondisi']) : '';
$filter_status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

// Build Query dengan sanitasi
$where = [];
if($filter_kategori != '') {
    $where[] = "a.kategori_id = '" . mysqli_real_escape_string($conn, $filter_kategori) . "'";
}
if($filter_kondisi != '') {
    $where[] = "a.kondisi = '" . mysqli_real_escape_string($conn, $filter_kondisi) . "'";
}
if($filter_status != '') {
    $where[] = "a.status = '" . mysqli_real_escape_string($conn, $filter_status) . "'";
}

$where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

$query = "
    SELECT a.*, 
           k.nama_kategori,
           g.nama_gedung,
           r.nama_ruangan
    FROM aset a
    LEFT JOIN kategori_aset k ON a.kategori_id = k.id
    LEFT JOIN gedung g ON a.gedung_id = g.id
    LEFT JOIN ruangan r ON a.ruangan_id = r.id
    $where_clause
    ORDER BY a.id DESC
";

$data = mysqli_query($conn, $query);

// Data untuk filter
$kategori = mysqli_query($conn, "SELECT * FROM kategori_aset ORDER BY nama_kategori");
?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="page-title mb-1">Laporan Aset</h3>
            <p class="text-muted mb-0">Kelola dan ekspor data laporan aset</p>
        </div>
        <div>
            <?php
            $export_params = http_build_query([
                'kategori' => $filter_kategori,
                'kondisi' => $filter_kondisi,
                'status' => $filter_status
            ]);
            ?>
            <a href="laporan_aset_export.php?<?= $export_params ?>" class="btn btn-success">
                <i class="bi bi-file-earmark-excel"></i> Ekspor ke Excel
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card-dashboard mb-4">
        <div class="card-header-custom">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>
                Filter Laporan
            </h5>
        </div>
        <div class="card-body-custom">
            <form method="GET" action="laporan_aset.php" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Kategori Aset</label>
                    <select name="kategori" class="form-control">
                        <option value="">-- Semua Kategori --</option>
                        <?php 
                        mysqli_data_seek($kategori, 0);
                        while($k = mysqli_fetch_assoc($kategori)): 
                        ?>
                            <option value="<?= $k['id'] ?>" <?= $filter_kategori == $k['id'] ? 'selected' : '' ?>>
                                <?= $k['nama_kategori'] ?>
                            </option>
                        <?php endwhile ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-control">
                        <option value="">-- Semua Kondisi --</option>
                        <option value="baik" <?= $filter_kondisi == 'baik' ? 'selected' : '' ?>>Baik</option>
                        <option value="rusak ringan" <?= $filter_kondisi == 'rusak ringan' ? 'selected' : '' ?>>Rusak Ringan</option>
                        <option value="rusak berat" <?= $filter_kondisi == 'rusak berat' ? 'selected' : '' ?>>Rusak Berat</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="aktif" <?= $filter_status == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="tidak aktif" <?= $filter_status == 'tidak aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i> Filter
                    </button>
                    <a href="laporan_aset.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise me-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="card-dashboard">
        <div class="card-header-custom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Data Laporan Aset
            </h5>
            <span class="badge bg-info">
                Total: <?= mysqli_num_rows($data) ?> data
            </span>
        </div>
        <div class="card-body-custom p-0">
            <div class="table-wrapper">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Gedung</th>
                            <th>Ruangan</th>
                            <th>Status</th>
                            <th>Kondisi</th>
                            <th>Keterangan</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($data) > 0): ?>
                            <?php $no = 1; while($a = mysqli_fetch_assoc($data)): ?>
                                <tr>
                                    <td class="ps-4"><?= $no++ ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($a['nama_aset']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-dark">
                                            <?= htmlspecialchars($a['nama_kategori'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($a['nama_gedung'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($a['nama_ruangan'] ?? '-') ?></td>
                                    <td>
                                        <span class="badge bg-<?= $a['status']=='aktif'?'success':'secondary' ?>">
                                            <?= ucfirst($a['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $a['kondisi']=='baik'?'success':
                                            ($a['kondisi']=='rusak ringan'?'warning':'danger')
                                        ?>">
                                            <?= ucfirst($a['kondisi']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small><?= htmlspecialchars(substr($a['keterangan'] ?? '-', 0, 50)) ?><?= strlen($a['keterangan'] ?? '') > 50 ? '...' : '' ?></small>
                                    </td>
                                    <td>
                                        <small><?= date('d/m/Y', strtotime($a['created_at'])) ?></small>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Tidak ada data ditemukan
                                </td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

