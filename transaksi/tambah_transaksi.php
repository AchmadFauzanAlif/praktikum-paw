<?php 
session_start();
if(empty($_SESSION["user"])) {
    header("Location: ../login.php");
}

$level = $_SESSION["user"]["level"];

if($level == 1 ) {
    header("Location: ../supplier/index.php");
    exit;
}

include "../function.php";

$query = "SELECT * FROM pelanggan";
$result = query($query);

function validasi($method, $nama, &$error) {
    $tanggalBatas = date("Y-m-d");

    if($nama == "waktu_transaksi"){
        if($method[$nama] < $tanggalBatas) {
            $error[$nama] = "Tanggal tidak boleh kurang dari hari ini";
            return false;
        }
    } else if ($nama == "keterangan"){
        if(strlen($method[$nama]) < 3){
            $error[$nama] = "Karakter keterangan kurang dari 3";
            return false;
        }
    } else if ($nama == "pelanggan_id") {
        if(empty($method[$nama])) {
            $error[$nama] = "Silakan pilih opsi";
            return false;
        }
    }

    return true;
}

$errors = [];

if(isset($_POST["tambah_transaksi"]) && isset($_POST["pelanggan_id"])) {
    $tanggalInputan = $_POST["waktu_transaksi"];
    $keterangan = $_POST["keterangan"];
    $total = $_POST["total"];

    validasi($_POST, "waktu_transaksi", $errors);
    validasi($_POST, "keterangan", $errors);
    validasi($_POST, "pelanggan_id", $errors);
    $pelanggan = $_POST["pelanggan_id"];

    if(empty($errors)){
        $tambah = "INSERT INTO `transaksi`(`waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES ('$tanggalInputan','$keterangan','$total','$pelanggan')";

        if(mysqli_query($conn, $tambah)) {
            header("Location: ../index.php");
            exit;
        } else {
            echo "Gagal menambahkan transaksi";
        }
    } else {
        foreach($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
} else if (isset($_POST["batal"])){
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Tambah Transaksi</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="waktu">Waktu Transaksi</label>
            <input type="date" name="waktu_transaksi" id="waktu" class="form-control">
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" cols="45" rows="3" class="form-control" placeholder="Masukkan Keterangan Transaksi"></textarea>
        </div>

        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" name="total" id="total" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label for="pelanggan">Pelanggan</label>
            <select name="pelanggan_id" id="pelanggan" class="form-control">
                <option value="" disabled selected>Pilih Pelanggan</option>
                <?php foreach($result as $rows) : ?>
                    <option value="<?php echo $rows["id"] ?>"><?php echo $rows["nama"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="tambah_transaksi" class="btn btn-primary">Tambah Transaksi</button>
        <button type="submit" name="batal" class="btn btn-secondary">Batal</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
