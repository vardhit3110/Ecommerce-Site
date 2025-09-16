<?php
require "db_connect.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];   

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];

    $stmt = mysqli_prepare($conn, "UPDATE userdata SET username=?, email=?, phone=?, city=?, gender=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $username, $email, $phone, $city, $gender, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        header("Location: ../dashboard.php");
        exit; 
    } else {
        echo "<script>alert('Update failed');window.location.href='dashboard.php';</script>";
    }
}
?>