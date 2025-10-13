<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

if (isset($_POST['cart_id']) && isset($_POST['change'])) {
    $cart_id = $_POST['cart_id'];
    $change = intval($_POST['change']);
    
    // Get current quantity
    $query = "SELECT quantity FROM viewcart WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cart_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cart_item = mysqli_fetch_assoc($result);
    
    $new_quantity = $cart_item['quantity'] + $change;
    
    if ($new_quantity < 1) {
        echo json_encode(['success' => false, 'message' => 'Quantity cannot be less than 1']);
        exit();
    }
    
    // Update quantity
    $update_query = "UPDATE viewcart SET quantity = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "ii", $new_quantity, $cart_id);
    
    if (mysqli_stmt_execute($update_stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}
?>