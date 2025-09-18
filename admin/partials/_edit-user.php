<?php
require "db_connect.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $gender = trim($_POST['gender']);

    $stmt = mysqli_prepare($conn, "UPDATE userdata SET username=?, phone=?, city=?, gender=? WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssssi', $username, $phone, $city, $gender, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../users_data.php?Status=Success");
            exit();
        } else {
            echo "<script>alert('User Data Not Updated!');window.location.href='../users_data.php?Status=Failed';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='../users_data.php?Status=Failed';</script>";
    }
}

?>