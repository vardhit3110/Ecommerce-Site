<?php
require "db_connect.php";
if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_id = $_POST['cart_id'];
    $new_quantity = intval($_POST['quantity']);

    $user_email = $_SESSION['email'];
    $user_query = "SELECT id FROM userdata WHERE email='$user_email'";
    $user_res = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_res);
    $user_id = $user_data['id'];

    if ($new_quantity < 1) {
        echo json_encode(['success' => false, 'message' => 'Invalid quantity', 'old_quantity' => $current_quantity]);
        exit;
    }

    $update_query = "UPDATE viewcart SET quantity = '$new_quantity' WHERE id = '$cart_id' AND user_id = '$user_id'";

    if (mysqli_query($conn, $update_query)) {
        $cart_total_query = "SELECT SUM(vc.quantity * p.product_price) as total FROM viewcart vc JOIN product p ON vc.product_id = p.product_Id WHERE vc.user_id = '$user_id'";
        $cart_total_res = mysqli_query($conn, $cart_total_query);
        $cart_total_row = mysqli_fetch_assoc($cart_total_res);
        $cart_total = number_format($cart_total_row['total'] ?? 0, 2);

        $cart_count_query = "SELECT COUNT(*) as count FROM viewcart WHERE user_id = '$user_id'";
        $cart_count_res = mysqli_query($conn, $cart_count_query);
        $cart_count_row = mysqli_fetch_assoc($cart_count_res);
        $cart_count = $cart_count_row['count'];

        echo json_encode([
            'success' => true,
            'cart_total' => $cart_total,
            'cart_count' => $cart_count
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>