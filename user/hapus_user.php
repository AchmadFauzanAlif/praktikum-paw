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

include '../function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM user WHERE id_user = $id";
    mysqli_query($conn, $query);
}

header("Location: tampilan_user.php");
exit;
?>
