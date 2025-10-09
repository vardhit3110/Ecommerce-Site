<?php
include "db_connect.php";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM feedback WHERE user_id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (mysqli_stmt_execute($stmt)) {
           header("location: ../feedbackList.php");
        } else {
            echo "<script>alert('User Feedback Not Deleted');window.location.href='../feedbackList.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='../feedbackList.php';</script>";
    }
}
?>