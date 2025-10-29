<?php
// create_razorpay_order.php
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

$username = $_SESSION['username'];

// Get user ID and address
$user_query = "SELECT id, address FROM userdata WHERE username = ?";
$stmt = mysqli_prepare($conn, $user_query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$user_result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit();
}

$user_id = $user['id'];
$address = $user['address'];

if (empty($address)) {
    echo json_encode(['success' => false, 'message' => 'Please set your delivery address before placing an order.']);
    exit();
}

// Calculate cart total
$cart_query = "SELECT product.product_price, viewcart.quantity 
               FROM product 
               JOIN viewcart ON product.product_Id = viewcart.product_id 
               WHERE viewcart.user_id = ?";
$stmt = mysqli_prepare($conn, $cart_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$cart_result = mysqli_stmt_get_result($stmt);

$total = 0;
while ($row = mysqli_fetch_assoc($cart_result)) {
    $total += $row['product_price'] * $row['quantity'];
}

if ($total == 0) {
    echo json_encode(['success' => false, 'message' => 'Your cart is empty.']);
    exit();
}

$shipping = 50;
$grand_total = ($total + $shipping) * 100; // Convert to paise

try {
    // Create order in your database first
    $order_code = random_int(100000, 999999);
    
    // Get cart items for order details
    $cart_items_query = "SELECT product.product_name, product.product_price, viewcart.quantity 
                        FROM product 
                        JOIN viewcart ON product.product_Id = viewcart.product_id 
                        WHERE viewcart.user_id = ?";
    $stmt = mysqli_prepare($conn, $cart_items_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $cart_items_result = mysqli_stmt_get_result($stmt);
    
    $cart_items = [];
    while ($row = mysqli_fetch_assoc($cart_items_result)) {
        $cart_items[] = [
            'product_name' => $row['product_name'],
            'price' => $row['product_price'],
            'quantity' => $row['quantity'],
            'subtotal' => $row['product_price'] * $row['quantity']
        ];
    }
    
    $product_details = json_encode($cart_items, JSON_UNESCAPED_UNICODE);
    
    // Insert order with pending status
    $insert_order = "INSERT INTO orders (user_id, product_details, total_amount, shipping_charge, 
                    payment_mode, payment_status, order_status, delivery_address, order_code) 
                    VALUES (?, ?, ?, ?, '2', '1', '1', ?, ?)";
    
    $stmt = mysqli_prepare($conn, $insert_order);
    $total_amount = $grand_total / 100; // Convert back to rupees for storage
    mysqli_stmt_bind_param($stmt, "isddsi", $user_id, $product_details, $total_amount, $shipping, $address, $order_code);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Failed to create order in database: ' . mysqli_error($conn));
    }
    
    $order_id = mysqli_insert_id($conn);

    // Create Razorpay order
    $receipt_id = 'rcpt_' . $order_code;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'amount' => $grand_total,
        'currency' => 'INR',
        'payment_capture' => 1,
        'receipt' => $receipt_id
    ]));
    curl_setopt($ch, CURLOPT_USERPWD, $razorpay_key_id . ':' . $razorpay_key_secret);
    
    $headers = ['Content-Type: application/json'];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);
    
    $razorpay_order = json_decode($result, true);
    
    if ($http_code !== 200 || isset($razorpay_order['error'])) {
        throw new Exception($razorpay_order['error']['description'] ?? 'Razorpay order creation failed');
    }
    
    // Update order with Razorpay order ID
    $update_order = "UPDATE orders SET razorpay_order_id = ? WHERE order_id = ?";
    $stmt = mysqli_prepare($conn, $update_order);
    mysqli_stmt_bind_param($stmt, "si", $razorpay_order['id'], $order_id);
    
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Failed to update order with Razorpay ID: ' . mysqli_error($conn));
    }
    
    echo json_encode([
        'success' => true,
        'order' => $razorpay_order,
        'key' => $razorpay_key_id,
        'amount' => $grand_total,
        'order_id' => $order_id
    ]);
    
} catch (Exception $e) {
    error_log("Razorpay Order Creation Error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

mysqli_close($conn);
?>