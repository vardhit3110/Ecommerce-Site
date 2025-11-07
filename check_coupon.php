<?php
require "db_connect.php";
session_start();

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'discount' => 0,
    'final_total' => 0
];

if (isset($_POST['coupon']) && isset($_POST['subtotal'])) {
    $coupon_code = trim($_POST['coupon']);
    $subtotal = floatval($_POST['subtotal']);

    // Coupon check query
    $query = "SELECT * FROM coupons WHERE promocode = '$coupon_code' AND status = '1' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $coupon = mysqli_fetch_assoc($result);

        $discount = floatval($coupon['discount']);
        $min_bill = floatval($coupon['min_bill_price']);

        if ($subtotal >= $min_bill) {
            // Calculate discounted total
            $discount_amount = ($subtotal * $discount) / 100;
            $final_total = $subtotal - $discount_amount;

            $response['success'] = true;
            $response['message'] = "Coupon applied successfully! ({$discount}% OFF)";
            $response['discount'] = round($discount_amount, 2);
            $response['final_total'] = round($final_total, 2);

            // Store applied coupon in session (optional)
            $_SESSION['applied_coupon'] = [
                'code' => $coupon_code,
                'discount' => $discount,
                'discount_amount' => $discount_amount,
                'final_total' => $final_total
            ];
        } else {
            $response['message'] = "Minimum bill ₹{$min_bill} required to use this coupon.";
        }
    } else {
        $response['message'] = "Invalid or inactive coupon code.";
    }
} else {
    $response['message'] = "Please enter a coupon code.";
}

echo json_encode($response);
?>
