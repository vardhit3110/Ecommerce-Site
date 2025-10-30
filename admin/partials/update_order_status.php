<?php
include "db_connect.php";

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'] ?? "";
    $payment_status = $_POST['payment_status'] ?? "";

    // Build dynamic update query
    $fields = [];
    $params = [];
    $types = "";

    if ($status !== "") {
        $fields[] = "order_status=?";
        $params[] = $status;
        $types .= "i";
    }

    if ($payment_status !== "") {
        $fields[] = "payment_status=?";
        $params[] = $payment_status;
        $types .= "i";
    }

    if (!empty($fields)) {
        $query = "UPDATE orders SET " . implode(", ", $fields) . " WHERE order_id=?";
        $params[] = $order_id;
        $types .= "i";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, $types, ...$params);

        if (mysqli_stmt_execute($stmt)) {
            echo "Order information updated successfully.";
        } else {
            echo "Failed to update order information.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "No status selected for update.";
    }
}
?>
