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
    $phone = $row['phone'];
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

$shipping = 60;
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
    <title>Online Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="assets/onlinePayment.css">

</head>

<body>
    <?php include "header.php"; ?>

    <div class="container cart-container">
        <div class="row">
            <div class="col-12 mt-4">
                <div class="border rounded text-center shadow-sm bg-light py-3">
                    <h4 class=" cart-heading mb-0 text-success">
                        <i class="fa-solid fa-credit-card"></i> Online Payment
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
                                    <td>₹<?php echo number_format($shipping, 2); ?></td>
                                </tr>

                                <tr class="table-bordered border-secondary table-light">
                                    <td colspan="4" class="text-end">Discount (<?php echo strtoupper($coupon_code); ?>)
                                    </td>
                                    <td class="text-success fw-semibold">
                                        ₹<?php echo number_format($discount_amount, 2); ?>
                                    </td>
                                </tr>

                                <tr class="table-bordered border-secondary table-active">
                                    <td colspan="4" class="text-end fw-bolder">Total</td>
                                    <td class="fw-bolder text-danger">₹<?php echo number_format($grand_total, 2); ?>
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
                        <h6><i class="fa-solid fa-circle-info me-2 text-warning"></i>Online Payment Instructions</h6>
                        <ul style="font-size: 14px;">
                            <li>Choose your preferred payment method: Card, UPI, or Net Banking.</li>
                            <li>Complete your payment securely using trusted gateways.</li>
                            <li>Ensure stable internet and avoid refreshing during the transaction.</li>
                        </ul>
                    </div>


                    <div class="mb-3 text-center">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa"
                                style="height: 35px; width: auto;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                                alt="MasterCard" style="height: 35px; width: auto;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/f2/Google_Pay_Logo.svg"
                                alt="Google Pay" style="height: 35px; width: auto;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/24/Paytm_Logo_%28standalone%29.svg"
                                alt="Paytm" style="height: 25px; width: auto;">
                        </div>
                    </div>

                    <!-- Order Button -->
                    <div class="mb-3 text-center">
                        <button type="button" id="rzpButton" class="btn btn-success w-100 fw-semibold">
                            <i class="fa-solid fa-credit-card me-2"></i>Confirm Order & Pay Online
                        </button>
                    </div>

                    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                    <script>
                        document.getElementById('rzpButton').addEventListener('click', function () {
                            // Create Razorpay order
                            const coupon = "<?php echo $coupon_code; ?>";
                            const discount = "<?php echo $discount_amount; ?>";

                            fetch('create_razorpay_order.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ coupon_code: coupon, discount_amount: discount })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const orderCode = data.order_code;
                                        openRazorpayCheckout(data.order, data.key, orderCode);
                                    }
                                    else {
                                        alert('Error: ' + data.message);
                                    }
                                })

                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error creating order: ' + error.message);
                                });
                        });

                        function openRazorpayCheckout(order, key, orderCode) {
                            const options = {
                                key: key,
                                amount: order.amount,
                                currency: order.currency,
                                name: "MobileSite",
                                description: "Order Payment",
                                image: "./store/images/logo.jpg",
                                order_id: order.id,
                                handler: function (response) {
                                    verifyPayment(response);
                                },
                                prefill: {
                                    name: "<?php echo $_SESSION['username']; ?>",
                                    email: "<?php echo $_SESSION['username']; ?>@gmail.com",
                                    contact: "<?php echo isset($phone) ? $phone : ''; ?>"
                                },
                                notes: {
                                    address: "MobileSite Office"
                                },
                                theme: {
                                    color: "#775bc4ff"
                                },
                                modal: {
                                    ondismiss: function () {
                                        alert('Payment cancelled. Please try again.');

                                        fetch('update_payment_cancel.php', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                            body: new URLSearchParams({ order_code: orderCode })
                                        })
                                            .then(res => res.json())
                                            .then(data => {
                                                if (data.success) {
                                                    console.log('Payment status updated to cancelled (3).');
                                                } else {
                                                    console.warn('Cancel update failed:', data.message);
                                                }
                                            })
                                            .catch(err => console.error('Cancel update error:', err));
                                    }
                                },
                                method: {
                                    upi: true,
                                    card: true,
                                    netbanking: true,
                                    wallet: true
                                }
                            };

                            const rzp = new Razorpay(options);
                            rzp.open();

                            rzp.on('payment.load', function () {
                                setTimeout(function () {
                                    const mobileInput = document.querySelector('input[type="tel"]');
                                    if (mobileInput) {
                                        mobileInput.focus();
                                    }
                                }, 500);
                            });
                        }
                        function verifyPayment(response) {
                            const button = document.getElementById('rzpButton');
                            const originalText = button.innerHTML;
                            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Verifying Payment...';
                            button.disabled = true;

                            fetch('verify_razorpay_payment.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify(response)
                            })
                                .then(response => response.json())
                                .then(data => {
                                    button.innerHTML = originalText;
                                    button.disabled = false;

                                    if (data.success) {
                                        alert(`Payment Successful!\nOrder Code: ${data.order_code}\nAmount: ₹${data.amount}\nPayment ID: ${data.payment_id}`);
                                        window.location.href = 'myorder.php?payment=success&order_code=' + data.order_code;
                                    } else {
                                        alert('Payment Verification Failed: ' + data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    button.innerHTML = originalText;
                                    button.disabled = false;
                                    alert('Error verifying payment: ' + error.message);
                                });
                        }
                    </script>

                </div>
            </div>

            <!-- Edit Address Modal -->
            <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content rounded-4">
                        <form method="post" action="./partials/online_addressupdate.php">
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