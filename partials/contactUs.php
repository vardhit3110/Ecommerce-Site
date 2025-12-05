<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please Login First');window.history.back();</script>";
    exit();
}

if (isset($_POST['send_contact'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    $check_email = "SELECT id FROM userdata WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result_email = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_email) > 0) {
        $row = mysqli_fetch_assoc($result_email);
        $user_id = $row['id']; 

        $query = "INSERT INTO contactus (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "issss", $user_id, $username, $email, $subject, $message);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Message Sent Successfully');window.location='../contactUs.php';</script>";
        } else {
            echo "<script>alert('Error Occurred');window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Email Not Registered');window.history.back();</script>";
    }
}
?>
