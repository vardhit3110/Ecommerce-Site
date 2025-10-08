<?php
session_start();
require "db_connect.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login first to add items to wishlist']);
        exit;
    }

    $user_id = $_SESSION['id'];
    $prod_id = intval($_POST['prod_id']);
    $action = $_POST['action'];

    if ($action === 'add') {
        // Check if already in wishlist
        $check_sql = "SELECT * FROM wishlist WHERE user_id = ? AND prod_id = ?";
        $stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $prod_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Product already in wishlist']);
        } else {
            $insert_sql = "INSERT INTO wishlist (user_id, prod_id) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            mysqli_stmt_bind_param($stmt, "ii", $user_id, $prod_id);

            if (mysqli_stmt_execute($stmt)) {
                // Get updated wishlist count
                $count_sql = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = ?";
                $stmt = mysqli_prepare($conn, $count_sql);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $count_result = mysqli_stmt_get_result($stmt);
                $count_row = mysqli_fetch_assoc($count_result);

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Product added to wishlist',
                    'wishlist_count' => $count_row['count']
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to add to wishlist']);
            }
        }
    } elseif ($action === 'remove') {
        $delete_sql = "DELETE FROM wishlist WHERE user_id = ? AND prod_id = ?";
        $stmt = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($stmt, "ii", $user_id, $prod_id);

        if (mysqli_stmt_execute($stmt)) {
            // Get updated wishlist count
            $count_sql = "SELECT COUNT(*) as count FROM wishlist WHERE user_id = ?";
            $stmt = mysqli_prepare($conn, $count_sql);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $count_result = mysqli_stmt_get_result($stmt);
            $count_row = mysqli_fetch_assoc($count_result);

            echo json_encode([
                'status' => 'success',
                'message' => 'Product removed from wishlist',
                'wishlist_count' => $count_row['count']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove from wishlist']);
        }
    }
}
?>