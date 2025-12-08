<?php
include "db_connect.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>

    </style>
</head>

<body>
    <?php
    if (isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];

        $query = "SELECT o.*, u.username FROM orders o JOIN userdata u ON o.user_id = u.id WHERE o.order_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $products = json_decode($row['product_details'], true);

            if (is_array($products) && count($products) > 0) {

                echo "<div class='order-details-card'>
                    <div class='row g-3'>";

                echo "<div class='col-md-4 text-center'>";
                echo "<p><span style='font-size: 12px; font-weight: 600;'>Order Status:</span> " . match ($row['order_status']) {
                    '1' => '<span style="background-color: #FFA500; color: black; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 600; letter-spacing: 1px;">Pending</span>',
                    '2' => '<span style="background-color: #1E90FF; color: white; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 600; letter-spacing: 1px;">Processing</span>',
                    '3' => '<span style="background-color: #9370DB; color: white; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 600; letter-spacing: 1px;">Shipped</span>',
                    '4' => '<span style="background-color: #32CD32; color: black; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 600; letter-spacing: 1px;">Delivered</span>',
                    '5' => '<span style="background-color: #DC143C; color: white; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 600; letter-spacing: 1px;">Cancelled</span>',
                    default => '<span style="background-color: #808080; color: black; padding: 2px 8px; border-radius: 5px; font-size: 10px; font-weight: 600; letter-spacing: 1px;">Unknown</span>'
                } . "</p>";


                foreach ($products as $p) {
                    $pname = $p['product_name'];
                    $qty = $p['quantity'];
                    $price = $p['price'];

                    $prodQuery = mysqli_query($conn, "SELECT product_name, product_image FROM product WHERE product_name = '$pname'");
                    $prod = mysqli_fetch_assoc($prodQuery);

                    $product_name = $prod['product_name'] ?? "Unknown Product";
                    $product_img = !empty($prod['product_image']) ? "./images/product_img/" . $prod['product_image'] : "images/product_img/Product is Empty1.png";

                    echo "
                <div class='mb-4 p-2 border rounded bg-light'>
                        <img src='{$product_img}' class='product-img mb-2' alt='Product' style='width:90px; height:90px; object-fit:contain; border-radius:10px;'>
                        <p class='fw-bold mb-1'>{$product_name}</p>
                        <small>Qty: {$qty} | Price: ₹{$price} each am to tu event ma gyo tyare maro wight shirt pan fadi nakho to ana paisa magiya me hato fatelo pan keva pur to peri sakay avo te vadhu fado have e perato pan nathi ana paisa magiya me tari pase thi</small>
                    </div>
                ";
                }

                echo "</div>";

                // right side — Order Details
                echo "<div class='col-md-8'>
                    <p><span class='info-label fw-bold'>Order Code:</span> {$row['order_code']}</p>
                    <p><span class='info-label fw-bold'>Order Date:</span> {$row['order_date']}</p>
                    <p><span class='info-label fw-bold'>Shipping Charge:</span> ₹{$row['shipping_charge']}</p>
                  
                    </p>
                    <p><span class='info-label fw-bold'>Delivery Address:</span> {$row['delivery_address']}</p>
                    <p><span class='info-label fw-bold'>Payment Mode:</span> " .
                    (($row['payment_mode'] == 1) ? 'Cash On Delivery' : 'Online Payment') . "</p>
                    <p><span class='info-label fw-bold'>Payment Status:</span> " . (
                    ($row['payment_status'] == 2) ? 'Success' :
                    (($row['payment_status'] == 3) ? 'Failed' : 'Pending')
                ) . "</p>
                    <p><span class='info-label fw-bold'>Total Amount:</span> ₹{$row['total_amount']}</p>
                </div>
            </div>
        </div>";
            } else {
                echo "<p class='text-center text-muted'>No product details found in this order.</p>";
            }
        } else {
            echo "<p class='text-center text-danger'>Order not found.</p>";
        }
    } else {
        echo "<p class='text-center text-danger'>Invalid request.</p>";
    }
    ?>
</body>

</html>