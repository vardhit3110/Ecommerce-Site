<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['username']) || !isset($_GET['order_code'])) {
    header("Location: index.php");
    exit();
}

$order_code = $_GET['order_code'];

// Get order details
$query = "SELECT * FROM orders WHERE order_code = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $order_code);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "header.php"; ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="text-success mb-3">
                            <i class="fas fa-check-circle fa-5x"></i>
                        </div>
                        <h3 class="card-title text-success">Payment Successful!</h3>
                        <p class="card-text">Thank you for your order.</p>
                        <div class="alert alert-info">
                            <strong>Order Code:</strong> <?php echo $order['order_code']; ?><br>
                            <strong>Amount Paid:</strong> ₹<?php echo $order['total_amount']; ?><br>
                            <strong>Payment ID:</strong> <?php echo $order['payment_id']; ?>
                        </div>
                        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                        <a href="order_history.php" class="btn btn-outline-secondary">View Order History</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include "footer.php"; ?>
</body>
</html>