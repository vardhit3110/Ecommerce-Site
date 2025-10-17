<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login first.'); window.location.href='../index.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $shipping = $_POST['shipping'];
    $total_amount = $_POST['total_amount'];

    $query = "SELECT address FROM userdata WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if (empty($user['address'])) {
        echo "<script>alert('Please set your delivery address before placing the order.'); window.history.back();</script>";
        exit();
    }

    $delivery_address = $user['address'];

    $query = "SELECT product.product_name, product.product_price, viewcart.quantity FROM product JOIN viewcart ON product.product_Id = viewcart.product_id WHERE viewcart.user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $cart_items = [];
    $grand_total = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $subtotal = $row['product_price'] * $row['quantity'];
        $cart_items[] = [
            'product_name' => $row['product_name'],
            'price' => $row['product_price'],
            'quantity' => $row['quantity'],
            'subtotal' => $subtotal
        ];
        $grand_total += $subtotal;
    }

    if (empty($cart_items)) {
        echo "<script>alert('Your cart is empty!'); window.location.href='../viewcart.php';</script>";
        exit();
    }

    $grand_total += $shipping;
    $randomNumber = random_int(111111, 999999);
    $product_details = json_encode($cart_items, JSON_UNESCAPED_UNICODE);
    $insert = "INSERT INTO orders (user_id, product_details, total_amount, shipping_charge, payment_mode, payment_status, order_status, delivery_address,order_code)
               VALUES (?, ?, ?, ?, '1', '1', '1', ?, ?)";
    $stmt = mysqli_prepare($conn, $insert);
    mysqli_stmt_bind_param($stmt, "isddsi", $user_id, $product_details, $grand_total, $shipping, $delivery_address, $randomNumber);

    if (mysqli_stmt_execute($stmt)) {
        $delete = "DELETE FROM viewcart WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $delete);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);

        echo "<script>alert('Your order has been placed successfully! Order ID: $randomNumber'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Something went wrong while placing the order.'); window.history.back();</script>";
    }

    mysqli_close($conn);
}
?>