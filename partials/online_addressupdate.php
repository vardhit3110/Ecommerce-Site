<?php
include "db_connect.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['addressupdate'])) {
    $user_id = intval($_POST['user_id']);
    $updated_address = trim($_POST['address']);

    if (empty($updated_address)) {
        $_SESSION['message'] = "Address cannot be empty.";
        $_SESSION['msg_type'] = "danger";
        header("Location: ../onlinePayment.php"); 
        exit();
    }

    $stmt = mysqli_prepare($conn, "UPDATE userdata SET address = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $updated_address, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Address updated successfully.";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        $_SESSION['msg_type'] = "danger";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: ../onlinePayment.php"); 
    exit();
} else {
    header("Location: ../onlinePayment.php");
    exit();
}
