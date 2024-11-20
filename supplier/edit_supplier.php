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
        };
    }
    
    return true;
}

include "../function.php";
$id = $_GET["id"];

$query = "SELECT * FROM supplier WHERE id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$errors = [];

if(isset($_POST["update"])){
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];
    $id = $_POST["id"];

    validasi($_POST, "nama", $errors);
    validasi($_POST, "telp", $errors);
    validasi($_POST, "alamat", $errors);

    if(empty($errors)){
        $edit = "UPDATE `supplier` SET `nama`='$nama',`telp`='$telp',`alamat`='$alamat' WHERE id = $id";
        if(mysqli_query($conn, $edit)){
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
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Data Master Supplier</h1>
        <div class="card p-4">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo isset($_POST["update"]) ? $nama : $row['nama']?>">
                </div>

                <div class="form-group">
                    <label for="telp">Telp</label>
                    <input type="text" name="telp" id="telp" class="form-control" value="<?php echo isset($_POST["update"]) ? $telp : $row['telp']?>">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo isset($_POST["update"]) ? $alamat : $row['alamat']?>">
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
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
