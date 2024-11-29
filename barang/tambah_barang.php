<?php
session_start();

$level = $_SESSION["user"]["level"];
if($level == 2 ) {
    header("Location: ../index.php");
    exit;
}


include "../function.php";

if (isset($_POST['add'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $insertQuery = "INSERT INTO barang (id ,kode_barang, nama_barang, harga, stok, supplier_id) 
                    VALUES (NULL ,'$kode_barang', '$nama_barang', '$harga', '$stok', '$supplier_id')";
    if (mysqli_query($conn, $insertQuery)) {
        header("Location: index.php"); 
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


$querySupplier = "SELECT * FROM supplier";
$resultSupplier = query($querySupplier);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <form method="POST" class="card p-4">
            <h2 class="text-center mb-4">Tambah Barang</h2>
            <div class="form-group">
                <label for="kode_barang">Kode Barang:</label>
                <input type="text" name="kode_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" name="nama_barang" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" name="stok" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="supplier_id">Supplier ID:</label>
                <select name="supplier_id" id="supplier_id" class="form-control">
                    <option value="" selected disabled>Pilih Supplier</option>
                    <?php foreach($resultSupplier as $row) : ?> 
                        <option value=" <?= $row["id"] ?> "><?= $row["nama"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="add" class="btn btn-success btn-block">Tambah Barang</button>
            <a href="index.php" class="btn btn-secondary btn-block">Kembali</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
