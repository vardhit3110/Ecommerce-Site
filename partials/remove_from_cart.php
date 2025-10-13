<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    
    $query = "DELETE FROM viewcart WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cart_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database delete failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid cart ID']);
}
?>