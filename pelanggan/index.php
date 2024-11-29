<?php 
session_start();

include "../function.php";
if($_SESSION["user"] == null) {
    header("Location: ../login.php");
}

$level = $_SESSION["user"]["level"];
if($level == 2 ) {
    header("Location: ../index.php");
    exit;
}


$result = query("SELECT * FROM pelanggan");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Pelanggan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h1>Data Master Pelanggan</h1>
        <div class="text-left mb-3">
            <a href="tambah_pelanggan.php" class="btn btn-primary">Tambah Data!</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>No telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $row) : ?>    
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["nama"] ?></td>
                    <td><?= $row["jenis_kelamin"] ?></td>
                    <td><?= $row["telp"] ?></td>
                    <td><?= $row["alamat"] ?></td>
                    <td>
                        <a href="hapus_pelanggan.php?id=<?php echo $row["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus supplier ini?')">Hapus</a>
                        <a href="edit_pelanggan.php?id=<?php echo $row["id"] ?>" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-left mb-3">
            <a href="../index.php" class="btn btn-primary">Kembali</a>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>