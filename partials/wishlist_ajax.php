<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['email'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login to add items to wishlist']);
        exit;
    }

    $product_id = intval($_POST['product_id']);
    $user_email = $_SESSION['email'];
    

    $user_query = "SELECT id FROM userdata WHERE email='$user_email'";
    $user_res = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_res);
    $user_id = $user_data['id'];
    
    $product_check = "SELECT * FROM product WHERE product_Id='$product_id' AND product_status='1'";
    $product_result = mysqli_query($conn, $product_check);
    
    if (mysqli_num_rows($product_result) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
        exit;
    }
    
    // Check if already in wishlist
    $wishlist_check = "SELECT * FROM wishlist WHERE user_id='$user_id' AND prod_id='$product_id'";
    $wishlist_result = mysqli_query($conn, $wishlist_check);
    
    if (mysqli_num_rows($wishlist_result) > 0) {
        // Remove from wishlist
        $delete_query = "DELETE FROM wishlist WHERE user_id='$user_id' AND prod_id='$product_id'";
        if (mysqli_query($conn, $delete_query)) {
            
            $count_query = "SELECT COUNT(*) AS total FROM wishlist WHERE user_id='$user_id'";
            $count_res = mysqli_query($conn, $count_query);
            $count_row = mysqli_fetch_assoc($count_res);
            $wishlist_count = $count_row['total'];
            
            echo json_encode([
                'status' => 'success', 
                'action' => 'removed', 
                'wishlist_count' => $wishlist_count
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove from wishlist']);
        }
    } else {
        // Add to wishlist
        $insert_query = "INSERT INTO wishlist (user_id, prod_id) VALUES ('$user_id', '$product_id')";
        if (mysqli_query($conn, $insert_query)) {
            
            $count_query = "SELECT COUNT(*) AS total FROM wishlist WHERE user_id='$user_id'";
            $count_res = mysqli_query($conn, $count_query);
            $count_row = mysqli_fetch_assoc($count_res);
            $wishlist_count = $count_row['total'];
            
            echo json_encode([
                'status' => 'success', 
                'action' => 'added', 
                'wishlist_count' => $wishlist_count
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add to wishlist']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>