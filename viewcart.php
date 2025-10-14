<?php
require "db_connect.php";
if (session_status() == PHP_SESSION_NONE) {
    @session_start();
}

if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
    $user_query = "SELECT id FROM userdata WHERE email='$user_email'";
    $user_res = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_res);
    $user_id = $user_data['id'];

    // Remove item
    if (isset($_GET['remove_id'])) {
        $remove_id = $_GET['remove_id'];
        $delete_query = "DELETE FROM viewcart WHERE id = '$remove_id' AND user_id = '$user_id'";
        mysqli_query($conn, $delete_query);
        header("Location: viewcart.php");
        exit();
    }

    // Update quantity
    if (isset($_GET['update_quantity'])) {
        $cart_id = $_GET['cart_id'];
        $new_quantity = $_GET['quantity'];

        // Validate quantity 
        if ($new_quantity < 1) {
            $new_quantity = 1;
        } elseif ($new_quantity > 7) {
            $new_quantity = 7;
        }


        $update_query = "UPDATE viewcart SET quantity = '$new_quantity' WHERE id = '$cart_id' AND user_id = '$user_id'";
        mysqli_query($conn, $update_query);
        header("Location: viewcart.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - MobileSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .cart-container {
            max-width: 1500px;
            padding: 0 15px;
        }

        h4.cart-heading {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        table.cart-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            padding: 12px;
            text-align: center;
        }

        table.cart-table td {
            vertical-align: middle;
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .cart-item-img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
        }

        .remove-icon {
            color: #000;
            font-size: 18px;
            cursor: pointer;
        }

        .remove-icon:hover {
            color: #dc3545;
        }

        .quantity-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            background: #f8f9fa;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #000;
        }

        .quantity-btn:hover {
            background: #e9ecef;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            height: 30px;
        }

        .cart-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-clear {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            opacity: 0.6;
            cursor: not-allowed;
        }

        .cart-info {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .shipping-box {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .shipping-box h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .shipping-box input,
        .shipping-box select {
            margin-bottom: 12px;
        }

        .payment-methods {
            margin-top: 15px;
        }

        .payment-methods img {
            width: 45px;
            margin-right: 8px;
        }

        @media (max-width: 768px) {

            table.cart-table th,
            table.cart-table td {
                font-size: 14px;
                padding: 10px;
            }

            .cart-actions {
                flex-direction: column;
                gap: 10px;
            }

            .shipping-box {
                margin-top: 30px;
            }
        }

        .text-muted1 {
            font-style: italic;
            font-size: 12px;
        }

        .country-lable,
        .state-lable,
        .zip-lable {
            font-weight: 500;
            font-size: 14px;
            color: #000;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="cart-container" style="margin: 50px ;">
        <h4 class="cart-heading">Your Cart</h4>

        <?php if (isset($_SESSION['email'])): ?>
            <?php
            $cart_query = "SELECT viewcart.*, product.product_name, product.product_price, product.product_image FROM viewcart JOIN product  ON viewcart.product_id = product.product_Id WHERE viewcart.user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $cart_query);
            $cart_total = 0;
            ?>

            <?php if (mysqli_num_rows($cart_result) > 0): ?>
                <div class="row">
                    <!-- Left Cart Table -->
                    <div class="col-lg-8">
                        <table class="table cart-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = mysqli_fetch_assoc($cart_result)): ?>
                                    <?php
                                    $item_total = $item['product_price'] * $item['quantity'];
                                    $cart_total += $item_total;
                                    $image_path = "admin/images/product_img/" . $item['product_image'];
                                    $product_image = file_exists($image_path) ? $image_path : "https://via.placeholder.com/80";
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="viewcart.php?remove_id=<?php echo $item['id']; ?>"
                                                onclick="return confirm('Remove this item?')" class="remove-icon">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $product_image; ?>" class="cart-item-img me-3" alt="">
                                                <div>
                                                    <div><?php echo htmlspecialchars($item['product_name']); ?></div>
                                                    <small>Qty: <span class="text-danger"><?php echo $item['quantity']; ?></span></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span style="font-weight: 600;">₹<?php echo number_format($item['product_price'], 2); ?></span></td>
                                        <td>
                                            <div class="quantity-controls">
                                                <a href="viewcart.php?update_quantity=1&cart_id=<?php echo $item['id']; ?>&quantity=<?php echo max(1, $item['quantity'] - 1); ?>"
                                                    class="quantity-btn">-</a>
                                                <input type="text" value="<?php echo $item['quantity']; ?>" class="quantity-input"
                                                    readonly>
                                                <a href="viewcart.php?update_quantity=1&cart_id=<?php echo $item['id']; ?>&quantity=<?php echo $item['quantity'] + 1; ?>"
                                                    class="quantity-btn">+</a>
                                            </div>
                                        </td>
                                        <td><span style="font-weight: 600; color: red;">₹<?php echo number_format($item_total, 2); ?></span></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <div class="cart-actions">
                            <a href="index.php" class="btn btn-outline-dark">← Continue Shopping</a>
                            <button class="btn-clear" disabled>Clear Shopping Cart</button>
                        </div>

                        <p class="cart-info mt-3">
                            We process all orders in INR. While the content of your cart is currently displayed in INR,
                            the checkout will use INR at the most current exchange rate.
                        </p>
                    </div>

                    <!-- Right Shipping Box -->
                    <div class="col-lg-4">
                        <div class="shipping-box">
                            <h5>Get Shipping Estimates</h5>
                            <label for="address_country" class="country-lable">Country</label>
                            <select class="form-select">
                                <option selected>Select a country...</option>
                                <option>India</option>
                                <option>USA</option>
                            </select>

                            <label for="address_province" class="state-lable">State</label>
                            <select class="form-select">
                                <option selected>Select a state...</option>
                                <option>Gujarat</option>
                                <option>Maharashtra</option>
                            </select>

                            <label for="address_zip" class="zip-lable">Postal/Zip Code</label>
                            <input type="text" class="form-control" placeholder="Postal / Zip Code">

                            <button class="btn btn-dark w-100 mt-2">Calculate Shipping</button>

                            <hr>

                            <div class="mt-2">
                                <h6 style="font-weight: 500;">Subtotal : <span
                                        style="color: green;  float: right; font-weight: 700;">₹<?php echo number_format($cart_total, 2); ?></span>
                                </h6>
                                <small class="text-muted1">Shipping & taxes calculated at checkout</small>
                            </div>
                            <p class="pt-0 m-0 fst-normal freeShipclaim" style="font-size: 14px;"><strong>FREE SHIPPING
                                </strong>ELIGIBLE <i class="fa fa-truck" aria-hidden="true"></i></p>

                            <div class="mt-3">
                                <label><input type="radio" name="payment" class="me-2">Cash on Delivery</label><br>
                                <label><input type="radio" name="payment" class="me-2">Online Payment</label>
                            </div>

                            <button class="btn btn-primary w-100 mt-3">Proceed to Checkout</button>

                            <div class="payment-methods text-center mt-3">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/3/38/American_Express.png?20240915104508"
                                    alt="">
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fa fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5>Your cart is empty</h5>
                    <a href="index.php" class="btn btn-dark mt-3">Start Shopping</a>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="text-center py-5">
                <h5>Please login to view your cart</h5>
                <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal" class="btn btn-dark mt-3">Login</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>