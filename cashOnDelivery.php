<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login first.'); window.location.href='index.php';</script>";
    exit();
}

$username = $_SESSION['username'];

// Get user ID
$stmt = mysqli_prepare($conn, "SELECT * FROM userdata WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['id'];
    $useraddress = $row['address'];
} else {
    echo "User not found.";
    exit();
}

$query = "SELECT product.product_name, product.product_image, product.product_price, viewcart.quantity FROM product JOIN viewcart ON product.product_Id = viewcart.product_id WHERE viewcart.user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


$cart_items = [];
$total = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $row['subtotal'] = $row['product_price'] * $row['quantity'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}

$shipping = 50;
$grand_total = $total + $shipping;

$discount_amount = 0;
$coupon_code = isset($_GET['coupon']) ? trim($_GET['coupon']) : 'none';

if ($coupon_code !== 'none' && $coupon_code !== '') {
    // Check coupon validity
    $query = "SELECT * FROM coupons WHERE promocode = ? AND status = '1' LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $coupon_code);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($coupon = mysqli_fetch_assoc($result)) {
        if ($total >= $coupon['min_bill_price']) {
            $discount_amount = ($total * $coupon['discount']) / 100;
            $grand_total = $total + $shipping - $discount_amount;
        } else {
            $msg = "Min order ₹{$coupon['min_bill_price']} required for coupon.";
        }
    } else {
        $msg = "Invalid or inactive coupon.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash On Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cart-container {
            max-width: 1300px;
            padding: 0 20px;
        }

        h4.cart-heading {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .summary-box {
            border: 1px solid #f5f5f5;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th {
            background: #fafafa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            border-bottom: 2px solid #eee;
        }

        .order-table td,
        .order-table th {
            padding: 15px;
            text-align: center;
            vertical-align: middle;
        }

        .order-table td.text-start {
            text-align: left;
        }

        .order-table tr {
            border-bottom: 1px solid #eee;
        }

        .order-table img {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .cart__meta-text {
            color: #555;
            font-size: 0.85rem;
        }

        tfoot td {
            font-weight: 600;
            border-top: none !important;
        }

        tfoot td.text-end {
            text-align: right;
        }

        .fw-bolder {
            font-weight: 700 !important;
        }

        @media(max-width:768px) {
            .summary-box {
                margin-top: 20px;
            }

            .order-table th,
            .order-table td {
                font-size: 0.9rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>

    <div class="container cart-container">
        <div class="row">
            <div class="col-12 mt-4">
                <div class="border rounded text-center shadow-sm bg-light py-3">
                    <h4 class=" cart-heading mb-0 text-success">
                        <i class="fa-regular fa-money-bill-1"></i> Cash On Delivery
                    </h4>
                </div>
            </div>
        </div>

        <div class="row mt-1 mb-5 g-4">
            <!-- Left Side: Order Summary -->
            <div class=" col-lg-8 col-md-12">
                <div class="summary-box bg-light">
                    <h5 class="mb-3">ORDER SUMMARY</h5>
                    <div class="table-responsive">
                        <table class="table order-table table-bordered align-middle">
                            <thead>
                                <tr class="table-active table-bordered border-secondary">
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($cart_items) > 0): ?>
                                    <?php foreach ($cart_items as $item): ?>
                                        <tr class="table-bordered border-secondary">
                                            <td>
                                                <img src="./<?php echo htmlspecialchars($item['product_image']); ?>"
                                                    alt="Product">
                                            </td>
                                            <td class="text-start">
                                                <strong>
                                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                                </strong>
                                                <div class="cart__meta-text"
                                                    style="font-size: 13px; font-weight: 600; color: blue;">
                                                    Qty :
                                                    <?php echo $item['quantity']; ?>
                                                </div>
                                                <div class="cart__meta-text" style="font-size: 11px;">
                                                    date :
                                                    <?php echo date("d-M-Y"); ?>
                                                </div>
                                            </td>
                                            <td>₹
                                                <?php echo number_format($item['product_price'], 2); ?>
                                            </td>
                                            <td>
                                                <?php echo $item['quantity']; ?>
                                            </td>

                                            <?php
                                            $Subtotal = $item['product_price'] * $item['quantity'];
                                            ?>
                                            <td>₹
                                                <?php echo number_format($Subtotal, 2); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="table-bordered border-secondary">
                                        <td colspan="5">No products found in your cart.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-bordered border-secondary table-light">
                                    <td colspan="4" class="text-end">Shipping</td>

                                    <td>+ ₹
                                        <?php echo number_format($shipping, 2); ?>
                                    </td>
                                </tr>
                                <tr class="table-bordered border-secondary table-light">
                                    <td colspan="4" class="text-end">Discount (<?php echo strtoupper($coupon_code); ?>)
                                    </td>
                                    <td class="fw-semibold">-
                                        ₹<?php echo number_format($discount_amount, 2); ?>
                                    </td>
                                </tr>
                                <tr class="table-bordered border-secondary table-active">
                                    <td colspan="4" class="text-end fw-bolder">Total</td>
                                    <td class="fw-bolder text-danger">
                                        ₹<?php echo number_format($grand_total, 2); ?>
                                    </td>
                                </tr>
                                <?php if (isset($msg)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-danger small"><?php echo $msg; ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="summary-box bg-light">
                    <h5 class="mb-3"><i class="fa-solid fa-truck-fast me-2 text-success"></i>Delivery Details</h5>

                    <!-- Delivery Address -->
                    <div class="mb-3 border rounded p-3 bg-white position-relative">
                        <h6 class="fw-bold mb-1"><i class="fa-solid fa-location-dot me-2 text-danger"></i>Delivery
                            Address</h6>
                        <p class="mb-1" style="font-size: 14px;">
                            <?php if (isset($useraddress)) {
                                echo $useraddress;
                            } else {
                                echo "<span class='text-danger' style='font-size: 11px;'>Please Enter Your Address</span>";
                            } ?>
                        </p>
                        <a href="#" class="text-decoration-none position-absolute top-0 end-0 mt-2 me-3 text-primary"
                            data-bs-toggle="modal" data-bs-target="#editAddressModal" style="font-size: 14px;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    </div>

                    <div class="mb-3">
                        <h6><i class="fa-solid fa-circle-info me-2 text-warning"></i>Cash On Delivery Instructions</h6>
                        <ul style="font-size: 14px;">
                            <li>Pay with cash at the time of delivery.</li>
                            <li>Orders are shipped within 1–3 business days.</li>
                            <li>Please keep exact change ready if possible.</li>
                        </ul>
                    </div>

                    <div class="mb-3 text-muted" style="font-size: 13px;">
                        <p><i class="fa-solid fa-tag me-2 text-danger"></i>Hurry! Only a few items left in stock.</p>
                        <p><i class="fa-solid fa-shield-halved me-2 text-success"></i>Secure and trusted delivery
                            guaranteed.</p>
                        <p><i class="fa-solid fa-box-open me-2 text-info"></i>Free returns within 7 days.</p>
                    </div>

                    <!-- Order Button -->
                    <form method="POST" action="./partials/_cash_place_order.php">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="hidden" name="shipping" value="<?php echo $shipping; ?>">
                        <input type="hidden" name="total_amount" value="<?php echo $grand_total; ?>">
                        <input type="hidden" name="coupon_code" value="<?php echo $coupon_code; ?>">
                        <input type="hidden" name="discount_amount" value="<?php echo $discount_amount; ?>">
                        <button type="submit" class="btn btn-success w-100 fw-semibold">
                            <i class="fa-solid fa-bag-shopping me-2"></i>Confirm Order & Pay on Delivery
                        </button>
                    </form>
                </div>
            </div>

            <!-- Edit Address Modal -->
            <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content rounded-4">
                        <form method="post" action="./partials/_addressupdate.php">
                            <div class="modal-header bg-success text-white py-2 rounded-top">
                                <h6 class="modal-title" id="editAddressModalLabel">
                                    <i class="fa-solid fa-pen-to-square me-2"></i>Edit Address
                                </h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-2">
                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                    <label for="address" class="form-label fw-semibold">Your Address</label>
                                    <textarea class="form-control rounded-3" id="address" rows="4" name="address"
                                        placeholder="Enter your updated address"><?php echo $useraddress; ?></textarea>
                                </div>
                            </div>

                            <div class="modal-footer py-2">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" name="addressupdate"
                                    class="btn btn-sm btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>