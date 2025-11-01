<?php
require "db_connect.php";

if (isset($_POST['update'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $bio = trim($_POST['bio']);

    $stmt = mysqli_prepare($conn, "UPDATE admin SET fname=?, lname=?, email=?, phone=?, bio=? WHERE id=1");

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssss', $first_name, $last_name, $email, $phone, $bio);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../adminProfile.php");
            exit();
        } else {
            echo "<script>alert('User Data Not Updated!');window.location.href='../adminProfile.php';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='../adminProfile.php';</script>";
    }
}
?>