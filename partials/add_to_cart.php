<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    $user_email = $_SESSION['email'];
    $user_query = "SELECT id FROM userdata WHERE email = ?";
    $stmt = mysqli_prepare($conn, $user_query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $user_result = mysqli_stmt_get_result($stmt);

    if ($user_data = mysqli_fetch_assoc($user_result)) {
        $user_id = $user_data['id'];

        $check_query = "SELECT * FROM viewcart WHERE user_id = ? AND product_id = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            header("Location: ../viewproduct.php?Productid=$product_id&msg=alreadyincart");
            
        } else {
            // Insert into viewcart
            $insert_query = "INSERT INTO viewcart (user_id, product_id) VALUES (?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $product_id);

            if (mysqli_stmt_execute($insert_stmt)) {
                header("Location: ../viewproduct.php?Productid=$product_id&msg=addedtocart");
            } else {

                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "User not found.";
    }
} else {
    echo "Invalid product.";
}
?>