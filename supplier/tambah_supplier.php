<?php 
session_start();
if($_SESSION["user"] == null) {
    header("Location: ../login.php");
}

function validasi($x, $y, &$error){
    if(empty($x[$y])) {
        $error[$y] = "Inputan $y kosong";
        return false;
    } 

    if($y == "nama"){
        if(!ctype_alpha($x[$y])){
            $error[$y] = "Inputan $y harus berupa huruf";
            return false;
        } 
    } else if ($y == "telp") {
        if(!ctype_digit($x[$y])){
            $error[$y] = "Inputan $y harus berupa angka";
            return false;
        }
    } else if ($y == "alamat") {
        if(!preg_match("/[0-9]/", $x[$y]) || !preg_match("/[a-zA-Z]/", $x[$y])) {
            $error[$y] = "Inputan $y harus minimal memiliki 1 angka dan 1 huruf";
            return false;
        }
    }
    return true;
}

include "../function.php";

$errors = [];
$nama = "";
$telp = "";
$alamat = "";

if(isset($_POST["simpan"])){
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    validasi($_POST, "nama", $errors);
    validasi($_POST, "telp", $errors);
    validasi($_POST, "alamat", $errors);

    if(empty($errors)){
        $query = "INSERT INTO supplier VALUES ('', '$nama', '$telp', '$alamat');";
        if(mysqli_query($conn, $query)){
            header("Location: tampilan_supplier.php");
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'><ul>";
        foreach($errors as $error){
            echo "<li>".$error."</li>";
        }
        echo "</ul></div>";
    }
} else if(isset($_POST["batal"])){
    header("Location: tampilan_supplier.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Supplier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Tambah Data Master Supplier Baru</h1>
        <div class="card p-4">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" value="<?php echo isset($_POST["nama"]) ? $nama : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="telp">Telp:</label>
                    <input type="text" name="telp" id="telp" class="form-control" placeholder="Telepon" value="<?php echo isset($_POST["telp"]) ? $telp : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" value="<?php echo isset($_POST["alamat"]) ? $alamat : ''; ?>">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    <button type="submit" name="batal" class="btn btn-secondary">Batal</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
