<?php 
include "../function.php";
session_start();
if($_SESSION["user"] == null) {
    header("Location: ../login.php");
}

$query = "SELECT * FROM supplier";
$result = mysqli_query($conn, $query);

function validasi($tes, $coba) {
    if(ctype_digit($tes[$coba])){
        return false;
    }

    return true;
}

$i = 0;

if(isset($_GET["cari"])) {
    $keyword = $_GET["keyword"];
    $cari = "SELECT * FROM supplier WHERE
    nama LIKE '%$keyword%' OR
    alamat LIKE '%$keyword%'";

    $result = mysqli_query($conn, $cari);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan Supplier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="container my-5">
        <h1 class="text-center mb-4">Data Supplier</h1>
        <div class="text-right mb-3">
            <a href="tambah_supplier.php" class="btn btn-primary">Tambah Data!</a>
        </div>
        <form action="" method="get">
            <input type="text" name="keyword" value="<?php echo isset($_GET["cari"]) ? $keyword : '' ?>">
            <button type="submit" name="cari">Cari</button>
        </form><br>

        <?php if(mysqli_num_rows($result) > 0) : ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Telp</th>
                        <th>Alamat</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) : ?>
                        <?php $i++ ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $row["nama"] ?></td>
                            <td><?php echo $row["telp"] ?></td>
                            <td><?php echo $row["alamat"] ?></td>
                            <td>
                                <a href="hapus_supplier.php?id=<?php echo $row["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus supplier ini?')">Hapus</a>
                                <a href="edit_supplier.php?id=<?php echo $row["id"] ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Data tidak ada</p>
        <?php endif; ?>

        <div class="text-left mb-3">
            <a href="../index.php" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
