<?php
include 'koneksi.php';

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

// Nama file
$filename = "Laporan_Aset_" . date('Y-m-d_His') . ".xls";

// Header untuk download Excel
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// BOM untuk UTF-8 (agar karakter khusus terbaca dengan benar)
echo "\xEF\xBB\xBF";
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Laporan Aset</x:Name>
                    <x:WorksheetOptions>
                        <x:PrintGridlines/>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
        }
        .header-title {
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        .header-info {
            margin-bottom: 20px;
            font-size: 10pt;
            color: #666;
        }
        .header-info div {
            margin-bottom: 5px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: #FFFFFF;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10pt;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 10pt;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header-title">LAPORAN ASET</div>
    <div class="header-info">
        <div><strong>Tanggal Ekspor:</strong> <?= date('d F Y H:i:s') ?></div>
        <?php 
        // Ambil info filter
        $filter_info = [];
        if($filter_kategori != '') {
            $kat_query = mysqli_query($conn, "SELECT nama_kategori FROM kategori_aset WHERE id='" . mysqli_real_escape_string($conn, $filter_kategori) . "'");
            if($kat = mysqli_fetch_assoc($kat_query)) {
                $filter_info[] = "Kategori: " . $kat['nama_kategori'];
            }
        }
        if($filter_kondisi != '') {
            $filter_info[] = "Kondisi: " . ucfirst($filter_kondisi);
        }
        if($filter_status != '') {
            $filter_info[] = "Status: " . ucfirst($filter_status);
        }
        if(!empty($filter_info)): 
        ?>
            <div><strong>Filter:</strong> <?= implode(', ', $filter_info) ?></div>
        <?php else: ?>
            <div><strong>Filter:</strong> Semua Data</div>
        <?php endif ?>
        <div><strong>Total Data:</strong> <?= mysqli_num_rows($data) ?> aset</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
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
                <?php $no = 1; while($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_aset'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['nama_kategori'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['nama_gedung'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['nama_ruangan'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= ucfirst($row['status']) ?></td>
                        <td><?= ucfirst($row['kondisi']) ?></td>
                        <td><?= htmlspecialchars($row['keterangan'] ?? '-', ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px;">
                        Tidak ada data ditemukan
                    </td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
</body>
</html>

