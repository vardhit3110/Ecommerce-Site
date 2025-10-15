<?php
include "connect.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first'); window.location.href='login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT 
    vc.product_id,
    vc.product_name,
    vc.image AS product_image,
    vc.price AS product_price,
    vc.qty,
    COALESCE(vc.date_added, vc.added_on, vc.created_at, '') AS date_added
FROM viewcart vc
WHERE vc.user_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f8f9fa;">

<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">🛒 Your Cart</h2>

    <?php if ($result->num_rows > 0) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price (₹)</th>
                        <th>Quantity</th>
                        <th>Total (₹)</th>
                        <th>Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    while ($row = $result->fetch_assoc()) {
                        $total = $row['product_price'] * $row['qty'];
                        $grand_total += $total;
                    ?>
                        <tr>
                            <td><img src="uploads/<?php echo htmlspecialchars($row['product_image']); ?>" width="80" height="80" class="rounded"></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo number_format($row['product_price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['qty']); ?></td>
                            <td><?php echo number_format($total, 2); ?></td>
                            <td><?php echo htmlspecialchars($row['date_added']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot class="table-info">
                    <tr>
                        <th colspan="4" class="text-end">Grand Total:</th>
                        <th colspan="2">₹<?php echo number_format($grand_total, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-warning text-center" role="alert">
            🛍️ Your cart is empty!
        </div>
    <?php } ?>

    <div class="text-center mt-4">
        <a href="shop.php" class="btn btn-outline-primary">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
</div>

</body>
</html>
