<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please login first to add location.'); window.location.href='../index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_location'])) {
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $email = $_SESSION['email'];

    $updateQuery = "UPDATE userdata SET country='$country', state='$state', zip_city2='$city' WHERE email='$email'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Location saved successfully!'); window.location.href='../viewcart.php?status=Success';</script>";
    } else {
        echo "<script>alert('Error saving location: " . mysqli_error($conn) . "'); window.location.href='../viewcart.php?status=Error';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='../viewcart.php';</script>";
}
?>