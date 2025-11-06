<?php
require "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $promo_code = mysqli_real_escape_string($conn, $_POST['promo_code']);
    $discount = (int) $_POST['discount'];
    $min_bill_price = (float) $_POST['min_bill_price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $check_query = "SELECT * FROM coupons WHERE promocode = '$promo_code'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Coupon code already exists! Please use a unique code.'); window.history.back();</script>";
        exit;
    }

    // Insert data
    $insert_query = "INSERT INTO coupons (promocode, discount, min_bill_price, description) VALUES ('$promo_code', '$discount', '$min_bill_price', '$description')";
    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Coupon added successfully!'); window.location.href='../coupons.php';</script>";
    } else {
        echo "<script>alert('Error: Could not add coupon.'); window.history.back();</script>";
    }
}
?>