<?php
include "db_connect.php";

if (isset($_GET['subscriber_id'])) {
    $user_id = $_GET['subscriber_id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM subscriber WHERE subscriber_id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (mysqli_stmt_execute($stmt)) {
           header("location: ../subscribers-manage.php");
        } else {
            echo "<script>alert('User Feedback Not Deleted');window.location.href='../subscribers-manage.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='../subscribers-manage.php';</script>";
    }
}
?>