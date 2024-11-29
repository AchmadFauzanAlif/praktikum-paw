<?php 
session_start();
include "function.php";

if($_SESSION["user"] == null) {
    header("Location: login.php");
}

$level = $_SESSION["user"]["level"];

if($level == 1 ) {
    header("Location: supplier/index.php");
    exit;
}

$transaksi = "SELECT 
        transaksi.id, 
        transaksi.waktu_transaksi, 
        transaksi.keterangan, 
        transaksi.total, 
        pelanggan.nama AS nama_pelanggan
    FROM 
        transaksi
    JOIN 
        pelanggan ON transaksi.pelanggan_id = pelanggan.id";

$resultTransaksi = mysqli_query($conn, $transaksi);

$i = 1;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Halaman Utama</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container py-2">
                <a class="navbar-brand fw-bold" href="#">Toko Fitrah</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="transaksi/tambah_transaksi.php" class="btn btn-primary me-2">Tambah Transaksi Baru!</a>
                        </li>
                        <?php if($level == 1): ?>
                            <li class="nav-item dropdown">
                                <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Data Master</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="barang/index.php">Data Barang</a></li>
                                    <li><a class="dropdown-item" href="supplier/index.php">Data Supplier</a></li>
                                    <li><a class="dropdown-item" href="pelanggan/index.php">Data Pelanggan</a></li>
                                    <li><a class="dropdown-item" href="user/index.php">Data User</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="transaksi/report_transaksi.php" class="btn btn-success ms-2">Lihat Laporan Penjualan</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Hallo, <?= $_SESSION['user']['nama'] ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item text-danger" href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?')">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container mt-5">
            <h2 class="text-center mb-4">Data Transaksi</h2>
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Waktu Transaksi</th>
                        <th>Keterangan</th>
                        <th>Total</th>
                        <th>Nama Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($resultTransaksi)) : ?>
                        <tr class="text-center">
                            <td><?php echo $i ?></td>
                            <td><?php echo $row["id"] ?></td>
                            <td><?php echo $row["waktu_transaksi"] ?></td>
                            <td><?php echo $row["keterangan"] ?></td>
                            <td>Rp <?php echo number_format($row["total"], 0, ',', '.') ?></td>
                            <td><?php echo $row["nama_pelanggan"] ?></td>
                            <td>
                                <a href="transaksi/detail_transaksi.php?id=<?php echo $row["id"] ?>" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                    <?php $i += 1; endwhile; ?>
                </tbody>
            </table>
        </div>

        <footer class="bg-dark text-white text-center py-3 mt-5">
            <p class="mb-0">&copy; 2024 Toko Fitrah. All Rights Reserved.</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
