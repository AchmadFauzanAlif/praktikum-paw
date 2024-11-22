<?php 
session_start();
if($_SESSION["user"] == null) {
    header("Location: ../login.php");
}
include '../function.php';
$id = $_GET['id'];

$query = "SELECT * FROM transaksi_detail";

$transaksiDetail = "SELECT
        transaksi_detail.transaksi_id,
        barang.nama_barang AS nama_barang,
        transaksi_detail.harga,
        transaksi_detail.qty
    FROM
        transaksi_detail
    JOIN
        barang ON transaksi_detail.barang_id = barang.id
    WHERE
        transaksi_detail.transaksi_id = $id;";

$result = query($transaksiDetail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Detail Transaksi</h1>
        
        <div class="text-center mb-4">
            <a href="tambah_transaksi_detail.php?id=<?php echo $id ?>" class="btn btn-success">Tambah Detail Transaksi Baru!</a>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Id Transaksi</th>
                    <th>Nama Barang</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $row) : ?>
                <tr>
                    <td><?php echo $row['transaksi_id'] ?></td>
                    <td><?php echo $row['nama_barang'] ?></td>
                    <td><?php echo $row['qty'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-left mb-3">
            <a href="../index.php" class="btn btn-primary">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
