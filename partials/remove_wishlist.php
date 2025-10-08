<?php
session_start();
include "../db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    
    // Check if user is logged in
    if (!isset($_SESSION['email'])) {
        $_SESSION['error'] = "Please log in to manage your wishlist.";
        header("Location: ../wishlist.php");
        exit();
    }

    $product_id = intval($_POST['product_id']);
    $user_email = $_SESSION['email'];
    
    // Get user ID
    $user_query = "SELECT id FROM userdata WHERE email=?";
    $stmt = mysqli_prepare($conn, $user_query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $user_result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($user_result) == 0) {
        $_SESSION['error'] = "User not found.";
        header("Location: ../wishlist.php");
        exit();
    }
    
    $user_data = mysqli_fetch_assoc($user_result);
    $user_id = $user_data['id'];
    
    // Check if the product exists in user's wishlist
    $check_query = "SELECT * FROM wishlist WHERE user_id=? AND prod_id=?";
    $stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Delete from wishlist
        $delete_query = "DELETE FROM wishlist WHERE user_id=? AND prod_id=?";
        $stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Product removed from wishlist successfully.";
        } else {
            $_SESSION['error'] = "Failed to remove product from wishlist. Please try again.";
        }
    } else {
        $_SESSION['error'] = "Product not found in your wishlist.";
    }
    
    header("Location: ../wishlist.php");
    exit();
    
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../wishlist.php");
    exit();
}
?>