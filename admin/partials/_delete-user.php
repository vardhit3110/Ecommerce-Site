<?php
require "db_connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM userdata WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('User Deleted Successful');window.location.href='../users_data.php';</script>";
        } else {
            echo "<script>alert('User Not Deleted');window.location.href='../users_data.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='../users_data.php';</script>";
    }
}
?>