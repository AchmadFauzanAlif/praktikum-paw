<?php 
include "../function.php";

if($_SESSION["user"] == null) {
    header("Location: login.php");
}

$level = $_SESSION["user"]["level"];
if($level == 2 ) {
    header("Location: ../index.php");
    exit;
}

if(isset($_POST["simpan"])) {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $hp = $_POST["hp"];
    $level = $_POST["level"];

    $query = "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES ('$username', '$password', '$nama', '$alamat', '$hp', '$level')";
    mysqli_query($conn, $query);
    header("Location: tampilan_user.php");
    exit;
} else if (isset($_POST["batal"])) {
    header("Location: tampilan_user.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4">Tambah User</h2>
        <form action="" method="post" class="p-4 border rounded bg-white">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama User:</label>
                <input type="text" name="nama" id="nama" class="form-control">
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <textarea name="alamat" id="alamat" cols="15" rows="4" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="hp" class="form-label">Nomor HP:</label>
                <input type="text" name="hp" id="hp" class="form-control">
            </div>
            <div class="mb-3">
                <label for="jenis" class="form-label">Jenis User:</label>
                <select name="level" id="jenis" class="form-select">
                    <option value="" selected disabled>-- Pilih Jenis User --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" name="simpan" class="btn btn-primary me-2">Simpan</button>
                <button type="submit" name="batal" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
