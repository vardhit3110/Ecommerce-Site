<?php
require "db_connect.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please login first.'); window.location.href='index.php';</script>";
    exit();
}

$email = $_SESSION['email'];
$user_id = null;

// Get user ID from email
$stmt = mysqli_prepare($conn, "SELECT id FROM userdata WHERE email = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $uid);
if (mysqli_stmt_fetch($stmt)) {
    $user_id = $uid;
}
mysqli_stmt_close($stmt);

// If user not found
if (!$user_id) {
    echo "<script>alert('User not found. Please login again.'); window.location.href='index.php';</script>";
    exit();
}

// Get cart items
$query = "SELECT * FROM viewcart WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
}
mysqli_stmt_close($stmt);

// Shipping cost
$shipping = 50.00;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash On Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include "links/icons.html"; ?>
    <style>
        .cart-container {
            max-width: 1400px;
            margin: auto;
            padding: 0 15px;
        }

        h4.cart-heading {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .table th {
            text-transform: uppercase;
            font-size: 13px;
            background: #f8f9fa;
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .summary-box {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        }

        .total-row td {
            font-weight: 700;
            font-size: 18px;
        }

        .place-order-btn {
            width: 100%;
            font-weight: 600;
        }

        @media(max-width:768px) {
            .summary-box {
                margin-top: 20px;
            }

            .product-img {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
<?php include_once "header.php"; ?>

<div class="container my-4 cart-container">
    <div class="row">
        <div class="col-12">
            <div class="border rounded text-center shadow-sm bg-light py-3">
                <h4 class="cart-heading mb-0 text-success">
                    <i class="fa-regular fa-money-bill-1"></i> Cash On Delivery
                </h4>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-3">
        <!-- Order Summary -->
        <div class="col-lg-8 col-md-12">
            <div class="summary-box">
                <h5 class="mb-3">Order Summary</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $grand_total = 0;
                        if (empty($cart_items)) {
                            echo "<tr><td colspan='5' class='text-center py-4'>Your cart is empty.</td></tr>";
                        } else {
                            foreach ($cart_items as $item) {
                                $price = (float) $item['product_price'];
                                $qty = (int) $item['quantity'];
                                $subtotal = $price * $qty;
                                $grand_total += $subtotal;

                                $img_path = !empty($item['product_image'])
                                    ? 'admin/images/product_img/' . htmlspecialchars($item['product_image'])
                                    : 'https://via.placeholder.com/120x120?text=No+Image';

                                $date_added = !empty($item['added_at'])
                                    ? date("d M Y", strtotime($item['added_at']))
                                    : '-';
                                ?>
                                <tr>
                                    <td><img src="<?php echo $img_path; ?>" alt="Product" class="product-img"></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['product_name'] ?? 'Product'); ?></strong><br>
                                        <small class="text-muted">Date: <?php echo $date_added; ?></small>
                                    </td>
                                    <td>₹<?php echo number_format($price, 2); ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td>₹<?php echo number_format($subtotal, 2); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <?php $total = $grand_total + $shipping; ?>
                <div class="row justify-content-end mt-3">
                    <div class="col-md-6 col-sm-8">
                        <table class="table">
                            <tr>
                                <td class="text-end">Shipping</td>
                                <td class="text-end">₹<?php echo number_format($shipping, 2); ?></td>
                            </tr>
                            <tr class="total-row">
                                <td class="text-end">Total</td>
                                <td class="text-end">₹<?php echo number_format($total, 2); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- COD Rules & Place Order -->
        <div class="col-lg-4 col-md-12">
            <div class="summary-box">
                <h5 class="mb-3">Cash On Delivery Rules</h5>
                <ul>
                    <li>Orders will be shipped within 1–3 working days.</li>
                    <li>Payment is collected in cash on delivery only.</li>
                    <li>Please ensure your address and mobile number are correct.</li>
                    <li>Refusal or incorrect address may incur return charges.</li>
                </ul>

                <hr>
                <form method="POST" action="place_order.php">
                    <input type="hidden" name="user_id" value="<?php echo intval($user_id); ?>">
                    <input type="hidden" name="shipping" value="<?php echo $shipping; ?>">
                    <input type="hidden" name="total_amount" value="<?php echo $total; ?>">
                    <button type="submit" class="btn btn-primary place-order-btn">Place Order (Cash On Delivery)</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
