<?php
require "db_connect.php";

if (isset($_GET['id'])) {
    $coupon_id = intval($_GET['id']);

    $check_query = "SELECT * FROM coupons WHERE id = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("i", $coupon_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        $delete_query = "DELETE FROM coupons WHERE id = ?";
        $stmt_delete = $conn->prepare($delete_query);
        $stmt_delete->bind_param("i", $coupon_id);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Coupon deleted successfully!');window.location.href='../coupons.php';</script>";
        } else {
            echo "<script>alert('Error: Could not delete coupon.');window.location.href='../coupons.php';</script>";
        }
        $stmt_delete->close();
    } else {
        echo "<script>alert('Coupon not found!');window.location.href='../coupons.php';</script>";
    }

    $stmt_check->close();
} else {
    echo "<script>alert('Invalid request!');window.location.href='../coupons.php';</script>";
}

$conn->close();
?>