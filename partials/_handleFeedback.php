<?php
require "db_connect.php";
session_start();

if (!isset($_POST['email']) || !isset($_POST['rating']) || !isset($_POST['comment'])) {
    echo "Please fill all fields.";
    exit;
}

$email = $_POST['email'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

$userQuery = "SELECT id FROM userdata WHERE email = '$email'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);

if (!$userData) {
    echo "User not found.";
    exit;
}

$user_id = $userData['id'];

$insertQuery = "INSERT INTO feedback (user_id, rating, comment) VALUES ('$user_id', '$rating', '$comment')";

if (mysqli_query($conn, $insertQuery)) {
    echo "success";
} else {
    echo "Something went wrong: " . mysqli_error($conn);
}
?>