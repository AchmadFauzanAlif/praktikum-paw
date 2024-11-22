<?php
include "../function.php";

$id = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM barang WHERE id = $id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: barang.php"); 
    exit;
}

if (isset($_POST['update'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $updateQuery = "UPDATE barang SET kode_barang='$kode_barang', nama_barang='$nama_barang', harga='$harga', stok='$stok', supplier_id='$supplier_id' WHERE id=$id";
    if (mysqli_query($conn, $updateQuery)) {
        header("Location: barang.php"); 
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <form method="POST" class="card p-4">
            <h2 class="text-center mb-4">Edit Barang</h2>
            <div class="form-group">
                <label for="kode_barang">Kode Barang:</label>
                <input type="text" name="kode_barang" value="<?= $row['kode_barang'] ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" name="nama_barang" value="<?= $row['nama_barang'] ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" name="harga" value="<?= $row['harga'] ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" name="stok" value="<?= $row['stok'] ?>" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="supplier_id">Supplier ID:</label>
                <input type="number" name="supplier_id" value="<?= $row['supplier_id'] ?>" class="form-control" required>
            </div>
            <button type="submit" name="update" class="btn btn-success btn-block">Update</button>
            <a href="barang.php" class="btn btn-secondary btn-block">Back</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
