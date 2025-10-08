<?php
require "db_connect.php";
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(['status' => 'login_required']);
    exit;
}

$user_email = $_SESSION['email'];
$get_user = mysqli_query($conn, "SELECT id FROM userdata WHERE email='$user_email'");
$user = mysqli_fetch_assoc($get_user);
$user_id = $user['id'];

if (isset($_POST['prod_id'])) {
    $prod_id = intval($_POST['prod_id']);


    $check = mysqli_query($conn, "SELECT * FROM wishlist WHERE user_id='$user_id' AND prod_id='$prod_id'");
    if (mysqli_num_rows($check) > 0) {
        // Remove
        mysqli_query($conn, "DELETE FROM wishlist WHERE user_id='$user_id' AND prod_id='$prod_id'");
        echo json_encode(['status' => 'removed']);
    } else {
        // Add
        mysqli_query($conn, "INSERT INTO wishlist (user_id, prod_id) VALUES ('$user_id', '$prod_id')");
        echo json_encode(['status' => 'added']);
    }
}
?>