<?php
include 'function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM user WHERE id_user = $id";
    mysqli_query($conn, $query);
}

header("Location: tampilan_user.php");
exit;
?>
