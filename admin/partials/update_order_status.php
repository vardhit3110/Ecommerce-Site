<?php
include "db_connect.php";

if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $query = "UPDATE orders SET order_status=? WHERE order_id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $status, $order_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "Order status updated successfully.";
    } else {
        echo "Failed to update status.";
    }
    mysqli_stmt_close($stmt);
}
?>