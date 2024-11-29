<?php
session_start();

$level = $_SESSION["user"]["level"];
if($level == 2 ) {
    header("Location: ../index.php");
    exit;
}

include "../function.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "DELETE FROM barang WHERE id = $id");
    header("location: index.php");
    exit;
}

$conn->close();
?>