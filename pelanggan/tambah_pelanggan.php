


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan</title>
</head>
<body>
    <form action="" method="post">
        <label for="nama">Nama: </label>
        <input type="text" name="nama" id="nama" require><br>

        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" require>
            <option value="" selected disabled>Jenis Kelamin</option>
            <option value="P">Perempuan</option>
            <option value="L">Laki Laki</option>
        </select><br>

        <label for="telp">No Telepon</label>
        <input type="text" name="telp" id="telp" require><br>

        <label for="">Alamat </label>
        <textarea name="" id="" cols="35" rows="3" require></textarea><br>
    </form>
</body>
</html>