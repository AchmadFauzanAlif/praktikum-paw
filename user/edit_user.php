<?php 
session_start();

if($_SESSION["user"] == null) {
    header("Location: login.php");
}

$level = $_SESSION["user"]["level"];
if($level == 2 ) {
    header("Location: ../index.php");
    exit;
}

include "../function.php";

if (isset($_GET['id']) > 0) {
    $id = $_GET['id'];
    $user = query("SELECT * FROM user WHERE id_user = $id")[0];
    
}

if (isset($_POST["simpan"])) {
    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); 
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['hp'];
    $level = $_POST['level'];

    $query = "UPDATE user SET username='$username', password='$password', nama='$nama', alamat='$alamat', hp='$hp', level='$level' WHERE id_user = $id";
    mysqli_query($conn, $query);
    header("Location: tampilan_user.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form action="edit_user.php" method="post">
        <input type="hidden" name="id_user" value="<?php echo $user["id_user"]; ?>">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
        <label>Password</label>
        <input type="password" name="password" required><br>
        <label>Nama</label>
        <input type="text" name="nama" value="<?php echo $user['nama']; ?>" required><br>
        <label>Alamat</label>
        <textarea name="alamat"><?php echo $user['alamat']; ?></textarea><br>
        <label>Nomor HP</label>
        <input type="text" name="hp" value="<?php echo $user['hp']; ?>"><br>
        <label>Level</label>
        <select name="level">
            <option value="1" <?php if ($user['level'] == 1) echo 'selected'; ?>>1</option>
            <option value="2" <?php if ($user['level'] == 2) echo 'selected'; ?>>2</option>
        </select><br>
        <button type="submit" name="simpan">Simpan</button>
    </form>
</body>
</html>
