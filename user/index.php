<?php 
session_start();
include "../function.php";
$result = query("SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tampilan User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4">Daftar User</h2>
        <div class="mb-3">
            <a href="tambah_user.php" class="btn btn-primary">Tambah User</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Level</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $row) : ?>
                    <tr>
                        <td><?= $row["id_user"] ?></td>
                        <td><?= $row["username"] ?></td>
                        <td><?= $row["nama"] ?></td>
                        <td><?= $row["level"] ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $row['id_user'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="hapus_user.php?id=<?= $row['id_user'] ?>" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-left mb-3">
            <a href="../index.php" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
