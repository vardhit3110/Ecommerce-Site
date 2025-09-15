<?php
require "db_connect.php";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];


    $check_email = "SELECT * FROM userdata WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result_email = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_email) > 0) {
        echo "<script>alert('Email Already Registered');window.location.href='../index.php';</script>";
    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);


        $reg_query = "INSERT INTO userdata (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $reg_query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>alert('Register Successful!'); window.location.href='../login.php';</script>";
        } else {
            echo "<script>alert('Registration Failed. Please try again later.');window.location.href='../index.php'</script>";
        }
    }
}
?>