<?php 
session_start();
include "../function.php";

$barang = query("SELECT * FROM barang");
$i = 1 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Data Barang</h2>
    <div class="text-right mb-3">
        <a href="tambah_barang.php" class="btn btn-primary">Tambah Barang</a>
    </div>
    <table class="table table-bordered table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>NO</th>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Nama Supplier</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($barang as $rows) : ?>
                <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $rows["id"] ?></td>
                    <td><?php echo $rows["kode_barang"] ?></td>
                    <td><?php echo $rows["nama_barang"] ?></td>
                    <td><?php echo $rows["harga"] ?></td>
                    <td><?php echo $rows["stok"] ?></td>
                    <td><?php echo $rows["supplier_id"] ?></td>
                    <td>
                                <a href="hapus_barang.php?id=<?php echo $rows["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus supplier ini?')">Hapus</a>
                                <a href="edit_barang.php?id=<?php echo $rows["id"] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                </tr>
                <?php $i += 1; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div class="text-left mb-3">
        <a href="../index.php" class="btn btn-primary">Kembali</a>
    </div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
