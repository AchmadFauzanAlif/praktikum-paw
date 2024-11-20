<?php 
$conn = mysqli_connect("localhost", "root", "", "store");

function query($tes){
    global $conn;
    $result = mysqli_query($conn, $tes);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

    return $rows;
}

function checkLogin($data, &$error) {
    global $conn;
    $username = $data["username"];
    $password = $data["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND password = SHA2('$password',256)");

    if (mysqli_num_rows($result) > 0 ) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user'] = $user;
        $_SESSION['level'] = $user['level'] == 1 ? 'owner': 'kasir';

        header("Location: index.php");
    } else {
        $error[] = "Username dan password salah";
    }
}

?>