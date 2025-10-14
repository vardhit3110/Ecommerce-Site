<?php
require "db_connect.php";
session_start();

header('Content-Type: application/json');

if (isset($_POST['product_id']) && isset($_SESSION['email'])) {
    $product_id = $_POST['product_id'];
    $user_email = $_SESSION['email'];

    $user_query = "SELECT id FROM userdata WHERE email='$user_email'";
    $user_res = mysqli_query($conn, $user_query);

    if ($user_res && mysqli_num_rows($user_res) > 0) {
        $user_data = mysqli_fetch_assoc($user_res);
        $user_id = $user_data['id'];

        // Delete item from cart
        $delete_query = "DELETE FROM viewcart WHERE user_id = ? AND product_id = ?";
        $stmt = mysqli_prepare($conn, $delete_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {

                $cart_count_query = "SELECT COUNT(*) AS total FROM viewcart WHERE user_id='$user_id'";
                $cart_count_res = mysqli_query($conn, $cart_count_query);
                $cart_count_row = mysqli_fetch_assoc($cart_count_res);
                $cart_count = $cart_count_row['total'];

                echo json_encode([
                    'success' => true,
                    'cart_count' => $cart_count,
                    'message' => 'Item removed from cart successfully!'
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Database error']);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['success' => false, 'error' => 'Statement preparation failed']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'User not found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters or user not logged in']);
}

mysqli_close($conn);
?>