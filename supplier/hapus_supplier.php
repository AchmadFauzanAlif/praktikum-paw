<?php 
session_start();
if($_SESSION["user"] == null) {
    header("Location: ../login.php");
}
include "../function.php";


if($_GET["id"] > 0){
    $id = $_GET["id"];
    $hapus = "DELETE FROM supplier WHERE id = $id";
    if(mysqli_query($conn, $hapus)){
        header("Location: tampilan_supplie.php");
        exit;
    }
}



// 

?>