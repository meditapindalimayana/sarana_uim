<?php
include 'koneksi.php';
include 'layout/header.php';
include 'layout/sidebar.php';

// Query statistik utama
$gedung = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM gedung"));
$ruangan = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM ruangan"));
$aset = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset"));
$kategori = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM kategori_aset"));
$perawatan = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM riwayat_perawatan"));

// Query kondisi aset
$baik = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset WHERE kondisi='baik'"));
$rusak_ringan = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset WHERE kondisi='rusak ringan'"));
$rusak_berat = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset WHERE kondisi='rusak berat'"));

// Query status aset
$aktif = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset WHERE status='aktif'"));
$tidak_aktif = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM aset WHERE status='tidak aktif'"));

// Aset terbaru (5 data)
$aset_terbaru = mysqli_query($conn, "
    SELECT a.*, k.nama_kategori, g.nama_gedung, r.nama_ruangan
    FROM aset a
    LEFT JOIN kategori_aset k ON a.kategori_id = k.id
    LEFT JOIN gedung g ON a.gedung_id = g.id
    LEFT JOIN ruangan r ON a.ruangan_id = r.id
    ORDER BY a.created_at DESC
    LIMIT 5
");

// Perawatan terbaru (5 data)
$perawatan_terbaru = mysqli_query($conn, "
    SELECT p.*, a.nama_aset
    FROM riwayat_perawatan p
    JOIN aset a ON p.aset_id = a.id
    ORDER BY p.tanggal DESC
    LIMIT 5
");
?>

<div class="main-content">
    <!-- Header Dashboard -->
    <div class="dashboard-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="dashboard-title mb-1">Dashboard</h2>
                <p class="dashboard-subtitle mb-0">
                    <i class="bi bi-calendar3 me-2"></i>
                    <?= date('l, d F Y') ?>
                </p>
            </div>
            <div class="dashboard-welcome">
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Overview Sistem
                </span>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card stat-card-primary">
                <div class="stat-card-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-card-content">
                    <h6 class="stat-card-label">Total Gedung</h6>
                    <h2 class="stat-card-value"><?= $gedung ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card stat-card-info">
                <div class="stat-card-icon">
                    <i class="bi bi-door-open"></i>
                </div>
                <div class="stat-card-content">
                    <h6 class="stat-card-label">Total Ruangan</h6>
                    <h2 class="stat-card-value"><?= $ruangan ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card stat-card-success">
                <div class="stat-card-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-card-content">
                    <h6 class="stat-card-label">Total Aset</h6>
                    <h2 class="stat-card-value"><?= $aset ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card stat-card-warning">
                <div class="stat-card-icon">
                    <i class="bi bi-tools"></i>
                </div>
                <div class="stat-card-content">
                    <h6 class="stat-card-label">Riwayat Perawatan</h6>
                    <h2 class="stat-card-value"><?= $perawatan ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Aset -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card-dashboard card-status">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-toggle-on text-success me-2"></i>
                        Status Aset
                    </h5>
                </div>
                <div class="card-body-custom">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="status-box status-active">
                                <div class="status-icon">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="status-info">
                                    <div class="status-label">Aktif</div>
                                    <div class="status-value"><?= $aktif ?></div>
                                    <div class="status-percent">
                                        <?= $aset > 0 ? number_format(($aktif/$aset*100), 1) : 0 ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="status-box status-inactive">
                                <div class="status-icon">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                                <div class="status-info">
                                    <div class="status-label">Tidak Aktif</div>
                                    <div class="status-value"><?= $tidak_aktif ?></div>
                                    <div class="status-percent">
                                        <?= $aset > 0 ? number_format(($tidak_aktif/$aset*100), 1) : 0 ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-dashboard">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-clipboard-check text-success me-2"></i>
                        Ringkasan Kondisi Aset
                    </h5>
                </div>
                <div class="card-body-custom">
                    <div class="condition-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="condition-label">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Baik
                            </span>
                            <div class="condition-info">
                                <strong class="condition-count"><?= $baik ?></strong>
                                <span class="condition-percent ms-2">
                                    (<?= $aset > 0 ? number_format(($baik/$aset*100), 1) : 0 ?>%)
                                </span>
                            </div>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-success progress-bar-striped" role="progressbar" 
                                 style="width: <?= $aset > 0 ? ($baik/$aset*100) : 0 ?>%"
                                 aria-valuenow="<?= $baik ?>" aria-valuemin="0" aria-valuemax="<?= $aset ?>"></div>
                        </div>
                    </div>
                    <div class="condition-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="condition-label">
                                <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                Rusak Ringan
                            </span>
                            <div class="condition-info">
                                <strong class="condition-count"><?= $rusak_ringan ?></strong>
                                <span class="condition-percent ms-2">
                                    (<?= $aset > 0 ? number_format(($rusak_ringan/$aset*100), 1) : 0 ?>%)
                                </span>
                            </div>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" 
                                 style="width: <?= $aset > 0 ? ($rusak_ringan/$aset*100) : 0 ?>%"
                                 aria-valuenow="<?= $rusak_ringan ?>" aria-valuemin="0" aria-valuemax="<?= $aset ?>"></div>
                        </div>
                    </div>
                    <div class="condition-item">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="condition-label">
                                <i class="bi bi-x-circle-fill text-danger me-2"></i>
                                Rusak Berat
                            </span>
                            <div class="condition-info">
                                <strong class="condition-count"><?= $rusak_berat ?></strong>
                                <span class="condition-percent ms-2">
                                    (<?= $aset > 0 ? number_format(($rusak_berat/$aset*100), 1) : 0 ?>%)
                                </span>
                            </div>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" 
                                 style="width: <?= $aset > 0 ? ($rusak_berat/$aset*100) : 0 ?>%"
                                 aria-valuenow="<?= $rusak_berat ?>" aria-valuemin="0" aria-valuemax="<?= $aset ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Kondisi Aset -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card-dashboard">
                <div class="card-header-custom">
                    <h5 class="mb-0">
                        <i class="bi bi-pie-chart-fill text-primary me-2"></i>
                        Visualisasi Kondisi Aset
                    </h5>
                </div>
                <div class="card-body-custom">
                    <div class="chart-container">
                        <canvas id="chartKondisi"></canvas>
                    </div>
                    <div class="chart-summary mt-4 pt-4 border-top">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="summary-item">
                                    <div class="summary-value text-success"><?= $baik ?></div>
                                    <div class="summary-label">Aset Baik</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="summary-item">
                                    <div class="summary-value text-warning"><?= $rusak_ringan ?></div>
                                    <div class="summary-label">Rusak Ringan</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="summary-item">
                                    <div class="summary-value text-danger"><?= $rusak_berat ?></div>
                                    <div class="summary-label">Rusak Berat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Terbaru -->
    <div class="row g-4">
        <!-- Aset Terbaru -->
        <div class="col-lg-6">
            <div class="card-dashboard">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history text-info me-2"></i>
                        Aset Terbaru
                    </h5>
                    <a href="aset.php" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-arrow-right me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body-custom p-0">
                    <div class="table-wrapper">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nama Aset</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($aset_terbaru) > 0): ?>
                                    <?php while($a = mysqli_fetch_assoc($aset_terbaru)): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="asset-name">
                                                    <strong><?= htmlspecialchars(substr($a['nama_aset'], 0, 30)) ?><?= strlen($a['nama_aset']) > 30 ? '...' : '' ?></strong>
                                                </div>
                                                <small class="text-muted d-block mt-1">
                                                    <i class="bi bi-building me-1"></i>
                                                    <?= htmlspecialchars($a['nama_gedung'] ?? '-') ?> - 
                                                    <?= htmlspecialchars($a['nama_ruangan'] ?? '-') ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-dark">
                                                    <?= htmlspecialchars($a['nama_kategori'] ?? '-') ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-condition bg-<?= 
                                                    $a['kondisi']=='baik'?'success':
                                                    ($a['kondisi']=='rusak ringan'?'warning':'danger')
                                                ?>">
                                                    <?= ucfirst($a['kondisi']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                            Tidak ada data aset
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perawatan Terbaru -->
        <div class="col-lg-6">
            <div class="card-dashboard">
                <div class="card-header-custom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-tools text-warning me-2"></i>
                        Riwayat Perawatan Terbaru
                    </h5>
                    <a href="perawatan.php" class="btn btn-sm btn-outline-warning">
                        <i class="bi bi-arrow-right me-1"></i> Lihat Semua
                    </a>
                </div>
                <div class="card-body-custom p-0">
                    <div class="table-wrapper">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nama Aset</th>
                                    <th>Jenis Perawatan</th>
                                    <th class="text-center">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($perawatan_terbaru) > 0): ?>
                                    <?php while($p = mysqli_fetch_assoc($perawatan_terbaru)): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <strong><?= htmlspecialchars(substr($p['nama_aset'], 0, 30)) ?><?= strlen($p['nama_aset']) > 30 ? '...' : '' ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info">
                                                    <?= htmlspecialchars($p['jenis_perawatan']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    <?= date('d/m/Y', strtotime($p['tanggal'])) ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                            Tidak ada data perawatan
                                        </td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Grafik Kondisi Aset
const ctxKondisi = document.getElementById('chartKondisi').getContext('2d');
const chartKondisi = new Chart(ctxKondisi, {
    type: 'doughnut',
    data: {
        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat'],
        datasets: [{
            data: [<?= $baik ?>, <?= $rusak_ringan ?>, <?= $rusak_berat ?>],
            backgroundColor: [
                'rgba(40, 167, 69, 0.8)',
                'rgba(255, 193, 7, 0.8)',
                'rgba(220, 53, 69, 0.8)'
            ],
            borderColor: [
                'rgba(40, 167, 69, 1)',
                'rgba(255, 193, 7, 1)',
                'rgba(220, 53, 69, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    font: {
                        size: 13,
                        weight: '500'
                    },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: {
                    size: 14,
                    weight: '600'
                },
                bodyFont: {
                    size: 13
                },
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        let value = context.parsed || 0;
                        let total = <?= $aset ?>;
                        let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return label + ': ' + value + ' aset (' + percentage + '%)';
                    }
                }
            }
        }
    }
});
</script>

<?php include 'layout/footer.php'; ?>
