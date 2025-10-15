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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php include "links/icons.html"; ?>
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

        .error {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 5px;
            bottom: 0%;
        }

        .deliver-to-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .deliver-to-text {
            flex: 1;
        }

        .calculate-btn-container {
            margin-left: 15px;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="cart-container" style="margin: 50px ;">

        <?php if (isset($_SESSION['email'])): ?>
            <?php
            $cart_query = "SELECT viewcart.*, product.product_name, product.product_price, product.product_image FROM viewcart JOIN product  ON viewcart.product_id = product.product_Id WHERE viewcart.user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $cart_query);
            $cart_total = 0;
            ?>

            <?php if (mysqli_num_rows($cart_result) > 0): ?>
                <div class="row">

                    <div class="container my-3">
                        <div class="row justify-content-center">
                            <div class="col-md-12 col-sm-10">
                                <div class="border rounded text-center shadow-sm bg-light py-3">
                                    <h4 class="cart-heading mb-0 text-success" style="font-weight: 700;"><i
                                            class="fa-solid fa-cart-plus"></i> Your Cart</h4>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                                    <small>Qty: <span
                                                            class="text-danger"><?php echo $item['quantity']; ?></span></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                style="font-weight: 600;">₹<?php echo number_format($item['product_price'], 2); ?></span>
                                        </td>
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
                                        <td><span
                                                style="font-weight: 600; color: red;">₹<?php echo number_format($item_total, 2); ?></span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <div class="cart-actions">
                            <a href="index.php" class="btn btn-outline-dark">← Continue Shopping</a>
                            <button class="btn-clear" disabled>Clear Shopping Cart</button>
                        </div>

                        <p class="cart-info mt-3">
                            We process all orders in Indian Rupees (INR). While your cart total is shown in INR, international
                            prices may vary slightly at checkout based on the latest currency exchange rates provided by your
                            payment provider. Final charges will always be displayed in INR at the time of payment.
                        </p>
                    </div>

                    <!-- Right Shipping Box -->
                    <div class="col-lg-4">
                        <div class="shipping-box">
                            <h5>Get Shipping Estimates</h5>

                            <div class="mb-3">
                                <label for="address_country" class="form-label">Country</label>
                                <select id="address_country" class="form-select">
                                    <option value="" selected>Select a country...</option>
                                    <option value="India">India</option>
                                </select>
                                <div id="countryError" class="error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="address_state" class="form-label">State</label>
                                <select id="address_state" class="form-select" disabled>
                                    <option value="" selected>Select a state...</option>
                                    <!-- States will be populated dynamically -->

                                </select>
                                <div id="stateError" class="error"></div>
                            </div>

                            <div class="mb-3">
                                <label for="address_zip" class="form-label">Postal/Zip Code</label>
                                <input type="text" id="address_zip" class="form-control" maxlength="6"
                                    placeholder="Postal / Zip Code">
                                <div id="zipError" class="error"></div>
                                <div id="zipLoading" class="loading text-primary" style="display: none;">Searching for city
                                    information...
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="deliver-to-container">
                                    <div class="deliver-to-text">
                                        <span>Deliver to: <span id="deliverTo" style="font-weight: 500; font-size: 13px;">Not
                                                specified</span></span>
                                    </div>
                                    <div class="calculate-btn-container">
                                        <form method="POST" id="locationForm" action="./partials/_order_address.php">
                                            <input type="hidden" name="country" id="countryField">
                                            <input type="hidden" name="state" id="stateField">
                                            <input type="hidden" name="zip" id="zipField">
                                            <input type="hidden" name="city" id="cityField">
                                            <input type="hidden" name="save_location" value="1">
                                            <button type="submit" class="btn btn-outline-primary btn-sm">Add Location</button>
                                        </form>

                                        <script>
                                            $('#locationForm').on('submit', function (e) {
                                                e.preventDefault();

                                                const country = $('#address_country').val();
                                                const state = $('#address_state').val();
                                                const zip = $('#address_zip').val();
                                                const city = $('#deliverTo').text();

                                                if (!country || !state || city === 'Not specified') {
                                                    alert('Please complete country, state, and zip before saving.');
                                                    return false;
                                                }

                                                $('#countryField').val(country);
                                                $('#stateField').val(state);
                                                $('#zipField').val(zip);
                                                $('#cityField').val(city);

                                                this.submit();
                                            });
                                        </script>

                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="mt-2">
                                <h6 style="font-weight: 500;">Subtotal : <span
                                        style="color: green;  float: right; font-weight: 700;">₹<?php echo number_format($cart_total, 2); ?></span>
                                </h6>
                                <small class="text-muted1">Shipping & taxes calculated at checkout</small>
                            </div>
                            <p class="pt-0 m-0 fst-normal freeShipclaim" style="font-size: 14px;"><strong>FREE SHIPPING
                                </strong>ELIGIBLE <i class="fa fa-truck" aria-hidden="true"></i></p>
                            <hr class="mt-2">

                            <div class="mt-3">
                                <label>
                                    <input type="radio" name="payment" class="me-2" value="cod">Cash on Delivery
                                    <i class="fa-regular fa-money-bill-1"></i>
                                </label><br>
                                <label>
                                    <input type="radio" name="payment" class="me-2" value="online">Online Payment
                                    <i class="fa-regular fa-credit-card"></i>
                                </label>
                            </div>

                            <button id="checkoutBtn" class="btn btn-primary w-100 mt-3">Proceed to Checkout</button>

                            <script>
                                document.getElementById('checkoutBtn').addEventListener('click', function (e) {
                                    e.preventDefault();
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const status = urlParams.get('status');

                                    if (status !== 'Success') {
                                        alert('Please add location first!');
                                        return;
                                    }

                                    const payment = document.querySelector('input[name="payment"]:checked');
                                    if (!payment) {
                                        alert('Please select a payment method.');
                                        return;
                                    }

                                    if (payment.value === 'cod') {
                                        window.location.href = 'cashOnDelivery.php';
                                    } else if (payment.value === 'online') {
                                        window.location.href = 'payment_gateway.php';
                                    }
                                });
                            </script>
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
                <div class="container my-5" style="min-height: 80vh;">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-md-8">
                            <div class="text-center py-5 border rounded bg-light shadow-sm">
                                <i class="fa fa-shopping-cart fa-4x text-muted mb-3"></i>
                                <h5>Your cart is empty</h5>
                                <a href="index.php" class="btn btn-dark mt-3">Start Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-sm-10">
                        <div class="border rounded p-4 text-center shadow-sm bg-light">
                            <h5 class="mb-3">Please login to view your cart</h5>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal" class="btn btn-dark">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="./links/viewcart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>