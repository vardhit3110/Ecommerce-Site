<?php
require "db_connect.php";
session_start();

if (!isset($_SESSION['id'])) {
    echo "<script>alert('Unauthorized access.'); window.location.href='../index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $user_id = $_SESSION['id'];
    $product_id = intval($_POST['product_id']);

    $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND prod_id = ?";
    $stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);

    echo "<script>alert('Item removed from wishlist.'); window.location.href='../wishlist.php';</script>";
    exit();
}
?>