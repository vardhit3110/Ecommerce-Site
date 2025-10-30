<?php
include "db_connect.php";
session_start();

if (!isset($_POST['order_id'])) {
    echo "Invalid request.";
    exit();
}

$order_id = intval($_POST['order_id']);
$user_id = $_SESSION['user_id'] ?? null;

$query = "UPDATE orders SET order_status = 5 WHERE order_id = ? AND order_status BETWEEN 1 AND 2";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Order cancelled successfully!";
} else {
    echo "Order cannot be cancelled now.";
}
?>
