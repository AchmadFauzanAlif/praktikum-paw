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

include "../function.php";
$id = $_GET["id"];

$tes = "SELECT
        transaksi_detail.transaksi_id,
        barang.nama_barang AS nama_barang,
        transaksi_detail.harga,
        transaksi_detail.qty
    FROM
        transaksi_detail
    JOIN
        barang ON transaksi_detail.barang_id = barang.id;";

$barang = mysqli_query($conn, "SELECT * FROM barang");
$transaksi = mysqli_query($conn, "SELECT * FROM transaksi");

if(isset($_POST["tambah_detail_transaksi"])) {
    $errors = [];

    if(empty($_POST["barang_id"]) || empty($_POST["transaksi_id"])) {
        $errors["transaksi"] = "Harus memilih id barang dan id transaksi";
    } else {
        $quantity = $_POST["quantity"];
        $barangId = $_POST["barang_id"];
        $transaksiId = $_POST["transaksi_id"];

        $queryTransaksiDetail = "SELECT * FROM transaksi_detail";
        $coba = mysqli_query($conn, $queryTransaksiDetail);
        
        while($cek = mysqli_fetch_assoc($coba)) {
            if ($barangId == $cek["barang_id"] && $transaksiId == $cek["transaksi_id"]) {
                $errors["barang"] = "Barang sudah ada dalam transaksi";
            } 
        }
    }
    
    if(empty($errors)){
        $query = "SELECT * FROM barang WHERE id = $barangId";
        $result = mysqli_query($conn, $query);
        while($harga = mysqli_fetch_assoc($result)) {
            $totalBarang = $quantity * $harga["harga"];

            $hasil = "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ('$transaksiId', '$barangId', '$totalBarang', '$quantity')";

            if(mysqli_query($conn, $hasil)){
                $updateTotalQuery = "UPDATE transaksi t
                SET t.total = (
                    SELECT SUM(td.harga) 
                    FROM transaksi_detail td 
                    WHERE td.transaksi_id = t.id
                )
                WHERE t.id = $transaksiId";
                mysqli_query($conn, $updateTotalQuery);

                header("Location: ../index.php");
                exit;
            }
        }
    } else {
        foreach($errors as $error){
            echo "<div class='alert alert-danger'>$error</div><br>";
        }
    }
}
else if (isset($_POST["batal"])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi Detail</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Tambah Transaksi Detail</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="barang">Pilih Barang</label>
            <select name="barang_id" id="barang" class="form-control">
                <option value="" disabled selected>Pilih Barang</option>
                <?php while($row = mysqli_fetch_assoc($barang)) : ?>
                <option value="<?php echo $row["id"] ?>"><?php echo $row["nama_barang"] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="transaksi">Pilih Transaksi</label>
            <select name="transaksi_id" id="transaksi" class="form-control">
                <option value="" disabled selected>Pilih Transaksi</option>
                <option value="<?php echo $id ?>"><?php echo $id ?></option>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Masukkan jumlah barang">
        </div>

        <button type="submit" name="tambah_detail_transaksi" class="btn btn-primary">Tambah Detail Transaksi</button>
        <button type="submit" name="batal" class="btn btn-secondary">Batal</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
