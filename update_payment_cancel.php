<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$user = $_SESSION['username'];
$order_code = $_POST['order_code'] ?? null;

if ($order_code) {
    $query = "UPDATE orders SET payment_status = '3' WHERE order_code = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $order_code);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Order not found or not updated"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Missing order code"]);
}
?>