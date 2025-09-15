<?php
require "db_connect.php";
session_start();

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = mysqli_prepare($conn, "SELECT * FROM userdata WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password');window.location.href='../login.php';</script>";
        }
    } else {
        echo "<script>alert('Email Not Registered');window.location.href='../login.php';</script>";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>