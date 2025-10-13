<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in to view your cart.'); window.location.href='index.php';</script>";
    exit();
}

$user_email = $_SESSION['email'];
$user_query = "SELECT id FROM userdata WHERE email='$user_email'";
$user_res = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_res);
$user_id = $user_data['id'];

$cart_query = "SELECT vc.*, p.product_name, p.product_image, p.product_price FROM viewcart vc JOIN product p ON vc.product_id = p.product_Id WHERE vc.user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_query);
$cart_items = mysqli_fetch_all($cart_result, MYSQLI_ASSOC);
$cart_count = mysqli_num_rows($cart_result);

// Calculate totals
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['product_price'] * $item['quantity'];
}
$platform_fee = 20;
$total_payable = $total_price + $platform_fee;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <?php include "links/icons.html"; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        img {
            max-width: 100%;
            height: auto;
        }

        .cart {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 60vh;
        }

        .empty-cart-cls {
            padding: 30px 15px;
            color: #333;
        }

        .empty-cart-cls h3 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-cart-cls h4 {
            font-weight: 400;
            color: #777;
            margin-bottom: 20px;
        }

        .cart-btn-transform {
            transition: 0.3s ease;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .cart-btn-transform:hover {
            transform: translateY(-2px);
            background-color: #0056b3;
            color: #fff;
            text-decoration: none;
        }

        #header-box {
            background-color: #ffffffff;
            height: 60px;
            width: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 8px;
            border: 1px solid #dee2e6;

        }

        /* .cart-header {
            background: #f8f9fa;
            color: #333;
            padding: 15px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        } */

        .cart-item {
            border: 1px solid #dee2e6;
            background-color: #ffffffff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 5px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .quantity-btn:hover {
            background: #f8f9fa;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 4px;
        }

        .price-details-card {
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .total-row {
            font-weight: bold;
            border-bottom: 2px solid #007bff;
        }

        .payment-option {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px;
            margin: 8px 0;
        }

        .checkout-btn {
            background: #28a745;
            border: none;
            padding: 12px;
            font-size: 1.1em;
            font-weight: bold;
            border-radius: 6px;
            color: white;
            width: 100%;
            margin-top: 15px;
        }

        .checkout-btn:hover {
            background: #218838;
        }

        .remove-btn {
            /* background: #dc3545; */
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            font-size: 0.9em;
        }

        .remove-btn:hover {
            /* background: #c82333; */
        }

        @media (max-width: 768px) {
            .price-details-card {
                margin-top: 20px;
            }

            .product-image {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>


    <!-- <div class="cart-header">
    <div class="container" style="max-width: 800px;">
        <h2 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>My Cart</h2>
    </div>
</div> -->
    <div class="cart-header mx-auto mt-5">
        <h2 class="mb-0 mt-2" id="header-box"><i class="fas fa-shopping-cart me-2"></i>My Cart</h2>
    </div>

    <div class="container mb-5 mt-3">
        <?php if ($cart_count > 0): ?>
            <div class="row">
                <!-- Left Side - Cart Items -->
                <div class="col-lg-8 col-md-7">
                    <div class="cart-items-container">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-item">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-3">
                                        <img src="./admin/images/product_img/<?php echo htmlspecialchars($item['product_image']); ?>"
                                            alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="product-image">
                                    </div>
                                    <div class="col-md-4 col-9">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                        <p class="text-muted mb-0">₹<?php echo number_format($item['product_price']); ?></p>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="quantity-controls">
                                            <button class="quantity-btn"
                                                onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                                            <input type="number" class="quantity-input" value="<?php echo $item['quantity']; ?>"
                                                min="1" max="5" readonly>
                                            <button class="quantity-btn"
                                                onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-3 text-md-center">
                                        <strong>₹<?php echo number_format($item['product_price'] * $item['quantity']); ?></strong>
                                    </div>
                                    <div class="col-md-1 col-3 text-end">
                                        <button class="btn btn-outline-danger remove-btn "
                                            onclick="removeFromCart(<?php echo $item['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Right Side - Price Details -->
                <div class="col-lg-4 col-md-5">
                    <div class="price-details-card">
                        <h5 class="mb-3">Price Details</h5>

                        <div class="price-row">
                            <span>Total Price:</span>
                            <span>₹<?php echo number_format($total_price); ?></span>
                        </div>

                        <div class="price-row">
                            <span>Platform Fee:</span>
                            <span>₹<?php echo number_format($platform_fee); ?></span>
                        </div>

                        <div class="price-row total-row">
                            <span>Total Payable:</span>
                            <span>₹<?php echo number_format($total_payable); ?></span>
                        </div><br>

                        <div class="mt-3">
                            <h6 class="mb-2">Payment Method:</h6>
                            <div class="payment-option">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod"
                                        checked>
                                    <label class="form-check-label" for="cod">
                                        Cash on Delivery
                                    </label>
                                </div>
                            </div>

                            <div class="payment-option">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="onlinePayment"
                                        value="online">
                                    <label class="form-check-label" for="onlinePayment">
                                        Online Payment
                                    </label>
                                </div>
                            </div>

                        </div>

                        <button class="btn btn-primary checkout-btn" onclick="proceedToCheckout()">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty Cart Message -->
            <center>
                <div class="col-md-12 my-2">
                    <div class="card">
                        <div class="card-body cart">
                            <div class="col-sm-12 empty-cart-cls text-center">
                                <img src="https://i.imgur.com/dCdflKN.png" width="130" height="130" class="img-fluid mb-4">
                                <h3><strong>Your Cart is Empty</strong></h3>
                                <h4>Add something to make me happy :)</h4>
                                <a href="index.php" class="btn btn-primary cart-btn-transform m-3">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
        <?php endif; ?>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(cartId, change) {
            fetch('./partials/update_cart_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `cart_id=${cartId}&change=${change}`
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating quantity: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating quantity');
                });
        }

        function removeFromCart(cartId) {
            if (confirm('Are you sure you want to remove this item from cart?')) {
                fetch('./partials/remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `cart_id=${cartId}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error removing item: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error removing item');
                    });
            }
        }

        function proceedToCheckout() {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            alert(`Proceeding to checkout with ${paymentMethod === 'online' ? 'Online Payment' : 'Cash on Delivery'}`);
        }
    </script>
</body>

</html>