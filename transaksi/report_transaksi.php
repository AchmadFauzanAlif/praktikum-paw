<?php 
session_start();
if($_SESSION["user"] == null) {
    header("Location: ../login.php");
}

$level = $_SESSION["user"]["level"];

if($level == 1 ) {
    header("Location: ../supplier/index.php");
    exit;
}

include '../function.php';

if (isset($_POST["excel"])) {
    $tanggal = $_POST["tanggal"];
    $total = $_POST["total"];
    $jumlahPendapatan = array_sum($total);
    $pelanggan = $_POST["pelanggan"];

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_transaksi.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<table border='1'>";
    
    echo "<tr><th colspan='3'>Rekap Laporan Penjualan " . $_POST['tanggalAwal'] . " sampai " . $_POST['tanggalAkhir'] . "</th></tr>";
    echo "<tr><td colspan='3'></td></tr>";

    echo "<tr><th>No</th><th>Total</th><th>Tanggal</th></tr>";

    $no = 1;
    for ($i = 0; $i < count($tanggal); $i++) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>Rp" . number_format($total[$i], 0, ',', '.') . "</td>";
        echo "<td>" . $tanggal[$i] . "</td>";
        echo "</tr>";
    }

    echo "<tr><td colspan='3'></td></tr>";

    echo "<tr><th>Jumlah Pelanggan</th><th colspan='2'>Jumlah Pendapatan</th></tr>";
    echo "<tr>";
    echo "<td>" . $pelanggan . " Orang</td>";
    echo "<td colspan='2'>Rp" . number_format($jumlahPendapatan, 0, ',', '.') . "</td>";
    echo "</tr>";

    echo "</table>";
    exit;
}



if(isset($_POST['cari']) && isset($_POST['tanggalAwal'])){
    $tanggalAwal = $_POST['tanggalAwal'];
    $tanggalAkhir = $_POST['tanggalAkhir'];

    $queryPelanggan = "SELECT 
            transaksi.waktu_transaksi, 
            pelanggan.nama AS pelanggan 
        FROM
            transaksi JOIN pelanggan ON 
            transaksi.pelanggan_id = pelanggan.id  
        WHERE 
            transaksi.waktu_transaksi 
        BETWEEN 
            '$tanggalAwal' AND '$tanggalAkhir'";

    $pelanggan = query($queryPelanggan);
    
    $query = "SELECT * FROM transaksi WHERE waktu_transaksi BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
    $hasil = query($query);

    $totalPenjualan = 0;
    foreach ($hasil as $transaksi) {
        $tanggal = $transaksi['waktu_transaksi'];
        if (!isset($totalPerTanggal[$tanggal])) {
            $totalPerTanggal[$tanggal] = 0;
        }
        $totalPerTanggal[$tanggal] += $transaksi['total'];
    }

    $tanggal = [];
    $total = [];

    foreach ($totalPerTanggal as $dataTanggal => $dataTotal) {
        $tanggal[] = $dataTanggal;
        $total[] = $dataTotal;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print, .form-container, .navbar, .btn, .d-flex, .alert {
                display: none !important;
            }
        }


        .table th, .table td {
            text-align: center;
            padding: 10px;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .content-container {
            max-width: 80%;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <a class="navbar-brand" href="tampilan_transaksi.php">Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Transaksi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../barang/index.php">Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../supplier/index.php">Supplier</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container content-container">
        <div class="form-container">
            <form action="" method="post" class="form-inline">
                <input type="date" name="tanggalAwal" class="form-control mr-2" required>
                <input type="date" name="tanggalAkhir" class="form-control mr-2" required>
                <button type="submit" name="cari" class="btn btn-primary">Cari</button>
            </form>
        </div>

        <?php if(isset($_POST['tanggalAwal']) && isset($_POST['tanggalAkhir'])): ?>
            <div class="alert alert-info">
                Menampilkan laporan dari tanggal <strong><?php echo $_POST['tanggalAwal']; ?></strong> sampai <strong><?php echo $_POST['tanggalAkhir']; ?></strong>.
            </div>
        <?php endif; ?>

        <div class="chart-container">
            <canvas id="transaksi"></canvas>
        </div>

        <?php if(!empty($totalPerTanggal)) : ?>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1; 
                    foreach($totalPerTanggal as $tableTanggal => $tableTotal) : ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $tableTanggal; ?></td>
                        <td>Rp <?php echo number_format($tableTotal, 0, ',', '.'); $totalPenjualan += $tableTotal; $i++; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table class="table table-bordered mt-2">
                <tr>
                    <th>Jumlah Pelanggan</th>
                    <th>Total Transaksi</th>
                </tr>
                <tr>
                    <td><?php echo count($pelanggan); ?> Orang</td>
                    <td>Rp <?php echo number_format($totalPenjualan, 0, ',', '.'); ?></td>
                </tr>
            </table>

            <div class="d-flex justify-content-between mt-4 no-print">
                <button class="btn btn-primary" onclick="window.print()">Cetak PDF</button>
                <form action="" method="post">
                    <?php foreach($totalPerTanggal as $dataTanggal => $dataTotal) : ?>
                        <input type="hidden" name="tanggal[]" value="<?php echo $dataTanggal; ?>">
                        <input type="hidden" name="total[]" value="<?php echo $dataTotal; ?>">
                        <?php endforeach; ?>
                    <input type="hidden" name="pelanggan" value="<?php echo count($pelanggan); ?>">
                    <input type="hidden" name="tanggalAwal" value="<?php echo $tanggalAwal; ?>">
                    <input type="hidden" name="tanggalAkhir" value="<?php echo $tanggalAkhir; ?>">
                    <button name="excel" type="submit" class="btn btn-success">Cetak Excel</button>
                </form>
            </div>

            <div class="mt-3">
                <a href="../index.php" class="btn btn-secondary">Kembali</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('transaksi');
        
        const tanggal = <?= json_encode($tanggal) ?>;
        const total = <?= json_encode($total) ?>;
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tanggal,
                datasets: [{
                    label: '# Data Penjualan',
                    data: total,
                    borderWidth: 1,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
