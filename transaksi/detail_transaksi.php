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
    <title>Document</title>
</head>
<body>

    <a href="tambah_transaksi_detail.php?id=<?php echo $id ?>" class="btn btn-success">Tambah Detail Transaksi Baru!</a>

    <table border="4" cellspacing="0" cellpadding="4">
        <tr>
            <th>Id transaksi</th>
            <th>Nama Barang</th>
            <th>Quantity</th>
        </tr>
        <?php foreach($result as $row) : ?>
        <tr>
            <td><?php echo $row['transaksi_id'] ?></td>
            <td><?php echo $row['nama_barang'] ?></td>
            <td><?php echo $row['qty'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>