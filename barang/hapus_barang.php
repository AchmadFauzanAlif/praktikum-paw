<?php
include "../function.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "DELETE FROM barang WHERE id = $id");
    header("location: index.php");
    exit;
}

$conn->close();
?>