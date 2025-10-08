<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to add items to your wishlist.'); window.location.href = '../login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Check if product already in wishlist
    $check_sql = "SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Product is already in your wishlist.'); window.history.back();</script>";
    } else {
        $insert_sql = "INSERT INTO wishlist (user_id, product_id, added_at) VALUES (?, ?, NOW())";
        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $product_id);

        if (mysqli_stmt_execute($insert_stmt)) {
            echo "<script>alert('Product added to wishlist.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Failed to add to wishlist.'); window.history.back();</script>";
        }
        mysqli_stmt_close($insert_stmt);
    }

    mysqli_stmt_close($check_stmt);
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>