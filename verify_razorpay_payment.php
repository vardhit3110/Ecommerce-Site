<?php
// verify_razorpay_payment.php
session_start();
include "db_connect.php";
include "razorpay_config.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['razorpay_payment_id'], $input['razorpay_order_id'], $input['razorpay_signature'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid payment data']);
    exit();
}

$razorpay_payment_id = $input['razorpay_payment_id'];
$razorpay_order_id = $input['razorpay_order_id'];
$razorpay_signature = $input['razorpay_signature'];

try {
    // Verify signature
    $generated_signature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $razorpay_key_secret);

    if ($generated_signature !== $razorpay_signature) {
        throw new Exception('Payment verification failed: Invalid signature');
    }

    // Get payment details from Razorpay
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payments/' . $razorpay_payment_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $razorpay_key_id . ':' . $razorpay_key_secret);
    $headers = ['Content-Type: application/json'];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);

    $payment = json_decode($result, true);

    if ($http_code !== 200 || isset($payment['error'])) {
        throw new Exception($payment['error']['description'] ?? 'Payment verification failed');
    }

    if ($payment['status'] === 'captured') {
        // Update order in database
        $username = $_SESSION['username'];

        // Get user ID
        $user_query = "SELECT id FROM userdata WHERE username = ?";
        $stmt = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $user_result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($user_result);
        $user_id = $user['id'];

        // Update order with payment success
        $update_query = "UPDATE orders 
                        SET payment_status = '2', 
                            payment_id = ?,
                            razorpay_payment_id = ?,
                            order_status = '2'
                        WHERE razorpay_order_id = ? 
                        AND user_id = ? 
                        AND payment_status = '1'";

        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "sssi", $razorpay_payment_id, $razorpay_payment_id, $razorpay_order_id, $user_id);
        mysqli_stmt_execute($stmt);

        if ($stmt->affected_rows > 0) {
            // Clear cart after successful payment
            $clear_cart = "DELETE FROM viewcart WHERE user_id = ?";
            $stmt = mysqli_prepare($conn, $clear_cart);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);

            // Get order details for response
            $order_query = "SELECT order_code, total_amount FROM orders WHERE razorpay_order_id = ?";
            $stmt = mysqli_prepare($conn, $order_query);
            mysqli_stmt_bind_param($stmt, "s", $razorpay_order_id);
            mysqli_stmt_execute($stmt);
            $order_result = mysqli_stmt_get_result($stmt);
            $order = mysqli_fetch_assoc($order_result);

            echo json_encode([
                'success' => true,
                'payment_id' => $razorpay_payment_id,
                'order_id' => $razorpay_order_id,
                'order_code' => $order['order_code'],
                'amount' => $order['total_amount'],
                'message' => 'Payment verified successfully'
            ]);
        } else {
            throw new Exception('Failed to update order in database. Order might not exist or already processed.');
        }
    } else {
        throw new Exception('Payment not captured. Status: ' . $payment['status']);
    }

} catch (Exception $e) {
    error_log("Payment Verification Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

mysqli_close($conn);
?>