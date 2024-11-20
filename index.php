<?php 
session_start();
include "function.php";

if($_SESSION["user"] == null) {
    header("Location: login.php");
}

// var_dump($_SESSION["user"]);
// die;
$level = $_SESSION["user"]["level"];

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

$i = 1
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Halaman Utama</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="pembungkus container py-2">
                <a class="navbar-brand fw-bold text-secondary visible" href="#">Toko Fitrah</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="transaksi/tambah_transaksi.php" class="btn btn-primary">Tambah Transaksi Baru!</a></li>
                    <?php if($level == 1) : ?>
                    <li class="nav-item dropdown">
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Data Master</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="barang/index.php">Barang</a></li>
                            <li><a class="dropdown-item" href="supplier/tampilan_supplier.php">Supplier</a></li>
                            <li><a class="dropdown-item" href="pelanggan/index.php">Pelanggan</a></li>
                            <li><a class="dropdown-item" href="tambah_user.phpn">Tambah User</a></li>
                            
                        </ul>
                    <?php elseif($level == 2) : ?>
                            <span> </span>
                    <?php endif; ?>
                    </li>
                    <li>
                        <a href="transaksi/report_transaksi.php" class="btn btn-success">Lihat Laporan Penjualan</a>    
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <span>Hallo <?= $_SESSION['user']['nama'] ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item bg-danger" href="logout.php" onclick="return confirm('apakah anda yakin ingin logout')">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="text-center">
        
    </div>
    
    
    
<div class="container mt-5">
    <h2 class="text-center">Data Transaksi</h2>
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
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
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $row["id"] ?></td>
                    <td><?php echo $row["waktu_transaksi"] ?></td>
                    <td><?php echo $row["keterangan"] ?></td>
                    <td><?php echo $row["total"] ?></td>
                    <td><?php echo $row["nama_pelanggan"] ?></td>
                    <td>
                        <a href="transaksi/detail_transaksi.php?id=<?php echo $row["id"] ?>">Detail Transaksi</a>
                    </td>
                </tr>
            <?php $i += 1; endwhile; ?>
        </tbody>
    </table><br>
</div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>
