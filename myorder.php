<?php
include "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please login first.'); window.location.href='index.php';</script>";
    exit();
}

$username = $_SESSION['username'];

// Get user ID
$stmt = mysqli_prepare($conn, "SELECT id FROM userdata WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['id'];
} else {
    echo "<script>alert('User not found.');window.history.back();</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <?php include "links/icons.html"; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f7f7f7;
        }

        .order-container {
            max-width: 1300px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .order-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn-action {
            border: none;
            background: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .btn-action:hover {
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            padding: 12px;
            border-bottom: 2px solid #ddd;
            text-align: center;
        }

        td {
            padding: 10px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .badge-status {
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            color: #fff;
        }

        .no-orders-container {
            text-align: center;
            margin-top: 80px;
        }

        .no-orders-image {
            width: 180px;
            height: auto;
            opacity: 0.9;
        }

        .no-orders {
            text-align: center;
            color: #888;
            margin-top: 40px;
            font-size: 1.2rem;
        }

        .view-product {
            color: #007bff;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .modal-body img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 10px;
        }

        .product-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            gap: 10px;
        }

        .product-row span {
            font-size: 14px;
        }

        .modal-body {
            max-height: 400px;
            overflow-y: auto;
        }

        .product-row:hover {
            transform: scale(1.01);
            transition: 0.2s;
            background: #eef8ff;
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>

    <div class="order-container">
        <div class="order-header-bar">
            <h4 class="m-0" style="font-weight: 700;">My Orders</h4>
            <div>
                <button class="btn-action" id="refreshBtn" title="Refresh Orders">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
                <button class="btn-action" id="printBtn" title="Print Orders">
                    <i class="fa-solid fa-print"></i>
                </button>
            </div>
        </div>

        <div id="ordersTable">
            <?php
            $query = "SELECT * FROM orders WHERE user_id = ? AND order_status IN ('1', '2', '3', '5') ORDER BY order_id DESC";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="table-responsive">
                    <table
                        class="table table-bordered table-responsive table-hover table-bordered border-dark align-middle">
                        <thead class="table-primary table-bordered border-dark">
                            <tr>
                                <th>Order Code</th>
                                <th>Order Date</th>
                                <th>Delivery Address</th>
                                <th>Payment Mode</th>
                                <th>Total Amount</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Cancel</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $order_id = $row['order_id'];
                                ?>
                                <tr id="orderRow<?php echo $order_id; ?>">
                                    <td><strong><?php echo htmlspecialchars($row['order_code']); ?></strong></td>
                                    <td style="font-size: 14px;">
                                        <?php echo !empty($row['order_date']) ? date("d M Y, h:i A", strtotime($row['order_date'])) : '—'; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['delivery_address'] ?? '—'); ?></td>
                                    <td>
                                        <?php
                                        if ($row['payment_mode'] == '1')
                                            echo "Cash on Delivery";
                                        elseif ($row['payment_mode'] == '2')
                                            echo "Online Payment";
                                        else
                                            echo "N/A";
                                        ?>
                                    </td>
                                    <td>₹<?php echo number_format($row['total_amount'] ?? 0, 2); ?></td>
                                    <td>
                                        <i class="fa-solid fa-eye view-product" style="color: #4e349d;" data-bs-toggle="modal"
                                            data-bs-target="#productModal<?php echo $order_id; ?>" title="View Products"></i>

                                        <!-- Dynamic Modal -->
                                        <div class="modal fade" id="productModal<?php echo $order_id; ?>" tabindex="-1"
                                            aria-labelledby="productModalLabel<?php echo $order_id; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="productModalLabel<?php echo $order_id; ?>">
                                                            Order Products</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <?php
                                                        $product_json = $row['product_details'];
                                                        $products = json_decode($product_json, true);

                                                        if (!empty($products) && is_array($products)) {
                                                            foreach ($products as $prod) {
                                                                $pname = htmlspecialchars($prod['product_name'] ?? 'Unknown Product');
                                                                $qty = htmlspecialchars($prod['quantity'] ?? '1');
                                                                $price = htmlspecialchars($prod['price'] ?? '0');

                                                                // Fetch product image from product table
                                                                $imgQuery = mysqli_query($conn, "SELECT product_image FROM product WHERE product_name = '" . mysqli_real_escape_string($conn, $pname) . "' LIMIT 1");
                                                                $imgRow = mysqli_fetch_assoc($imgQuery);
                                                                $image = !empty($imgRow['product_image'])
                                                                    ? "./admin/images/product_img/" . htmlspecialchars($imgRow['product_image'])
                                                                    : "./admin/images/product_img/Product is Empty.png";
                                                                ?>
                                                                <div class="product-row"
                                                                    style="display:flex;align-items:flex-start;gap:15px;background:#f9f9f9;border-radius:10px;padding:10px;margin-bottom:10px;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                                                    <img src="<?php echo $image; ?>" alt="<?php echo $pname; ?>"
                                                                        style="width:90px;height:90px;border-radius:8px;object-fit:cover;">
                                                                    <div style="display:flex;flex-direction:column;">
                                                                        <strong
                                                                            style="font-size:15px;color:#333;"><?php echo $pname; ?></strong>
                                                                        <span style="font-size:13px;color:#666;margin-top:4px;">Qty:
                                                                            <?php echo $qty; ?></span>
                                                                        <span
                                                                            style="font-size:13px;color:#007bff;margin-top:3px;">₹<?php echo number_format($price, 2); ?></span>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                            echo "<p class='text-center text-muted'>No product details available.</p>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $status = $row['order_status'];
                                        echo $orderMode = ($status == 1)
                                            ? '<span class="badge text-warning" style="background-color: hsla(43, 100%, 95%, 1.00);">Pending</span>'
                                            : (($status == 2)
                                                ? '<span class="badge text-primary" style="background-color: hsla(200, 85%, 92%, 1.00);">Processing</span>'
                                                : (($status == 3)
                                                    ? '<span class="badge" style="background-color: hsla(260, 70%, 92%, 1.00); color: purple;">Shipped</span>'
                                                    : (($status == 4)
                                                        ? '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Delivered</span>'
                                                        : (($status == 5)
                                                            ? '<span class="badge text-danger" style="background-color: hsla(0, 75%, 92%, 1.00);">Cancelled</span>'
                                                            : '<span class="badge text-secondary" style="background-color: hsla(0, 0%, 85%, 1.00);">Unknown</span>'))));
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($status >= 1 && $status <= 3) { ?>
                                            <button class="btn btn-outline-danger btn-sm cancelOrder"
                                                data-id="<?php echo $order_id; ?>">Cancel</button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                echo '<div class="no-orders-container">
  <img src="./admin/images/product_img/Product is Empty.png" alt="No Orders" class="no-orders-image">
  <p class="no-orders">You have not placed any orders yet.</p>
</div>';
            }
            ?>
        </div>

        <!-- Complate Order -->
        <div class="order-header-bar mt-4">
            <h4 class="m-0" style="font-weight: 700;">Deliver Order</h4>
        </div>
        <div id="ordersTable">
            <?php
            $query = "SELECT * FROM orders WHERE user_id = ? AND order_status='4' ORDER BY order_id DESC";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="table-responsive">
                    <table
                        class="table table-bordered table-responsive table-hover table-bordered border-dark align-middle">
                        <thead class="table-success table-bordered border-dark">
                            <tr>
                                <th>Order Code</th>
                                <th>Order Date</th>
                                <th>Delivery Address</th>
                                <th>Payment Mode</th>
                                <th>Total Amount</th>
                                <th>Product</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $order_id = $row['order_id'];
                                ?>
                                <tr id="orderRow<?php echo $order_id; ?>">
                                    <td><strong><?php echo htmlspecialchars($row['order_code']); ?></strong></td>
                                    <td style="font-size: 14px;">
                                        <?php echo !empty($row['order_date']) ? date("d M Y, h:i A", strtotime($row['order_date'])) : '—'; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['delivery_address'] ?? '—'); ?></td>
                                    <td>
                                        <?php
                                        if ($row['payment_mode'] == '1')
                                            echo "Cash on Delivery";
                                        elseif ($row['payment_mode'] == '2')
                                            echo "Online Payment";
                                        else
                                            echo "N/A";
                                        ?>
                                    </td>
                                    <td>₹<?php echo number_format($row['total_amount'] ?? 0, 2); ?></td>
                                    <td>
                                        <i class="fa-solid fa-eye view-product" style="color: #4e349d;" data-bs-toggle="modal"
                                            data-bs-target="#productModal<?php echo $order_id; ?>" title="View Products"></i>

                                        <!-- Dynamic Modal -->
                                        <div class="modal fade" id="productModal<?php echo $order_id; ?>" tabindex="-1"
                                            aria-labelledby="productModalLabel<?php echo $order_id; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="productModalLabel<?php echo $order_id; ?>">
                                                            Order Products</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <?php
                                                        $product_json = $row['product_details'];
                                                        $products = json_decode($product_json, true);

                                                        if (!empty($products) && is_array($products)) {
                                                            foreach ($products as $prod) {
                                                                $pname = htmlspecialchars($prod['product_name'] ?? 'Unknown Product');
                                                                $qty = htmlspecialchars($prod['quantity'] ?? '1');
                                                                $price = htmlspecialchars($prod['price'] ?? '0');

                                                                // Fetch product image from product table
                                                                $imgQuery = mysqli_query($conn, "SELECT product_image FROM product WHERE product_name = '" . mysqli_real_escape_string($conn, $pname) . "' LIMIT 1");
                                                                $imgRow = mysqli_fetch_assoc($imgQuery);
                                                                $image = !empty($imgRow['product_image'])
                                                                    ? "./admin/images/product_img/" . htmlspecialchars($imgRow['product_image'])
                                                                    : "./admin/images/product_img/Product is Empty.png";
                                                                ?>
                                                                <div class="product-row"
                                                                    style="display:flex;align-items:flex-start;gap:15px;background:#f9f9f9;border-radius:10px;padding:10px;margin-bottom:10px;box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                                                                    <img src="<?php echo $image; ?>" alt="<?php echo $pname; ?>"
                                                                        style="width:90px;height:90px;border-radius:8px;object-fit:cover;">
                                                                    <div style="display:flex;flex-direction:column;">
                                                                        <strong
                                                                            style="font-size:15px;color:#333;"><?php echo $pname; ?></strong>
                                                                        <span style="font-size:13px;color:#666;margin-top:4px;">Qty:
                                                                            <?php echo $qty; ?></span>
                                                                        <span
                                                                            style="font-size:13px;color:#007bff;margin-top:3px;">₹<?php echo number_format($price, 2); ?></span>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        } else {
                                                            echo "<p class='text-center text-muted'>No product details available.</p>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <?php
                                        $status = $row['order_status'];
                                        echo $orderMode = ($status == 1)
                                            ? '<span class="badge text-warning" style="background-color: hsla(43, 100%, 95%, 1.00);">Pending</span>'
                                            : (($status == 2)
                                                ? '<span class="badge text-primary" style="background-color: hsla(200, 85%, 92%, 1.00);">Processing</span>'
                                                : (($status == 3)
                                                    ? '<span class="badge" style="background-color: hsla(260, 70%, 92%, 1.00); color: purple;">Shipped</span>'
                                                    : (($status == 4)
                                                        ? '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Delivered</span>'
                                                        : (($status == 5)
                                                            ? '<span class="badge text-danger" style="background-color: hsla(0, 75%, 92%, 1.00);">Cancelled</span>'
                                                            : '<span class="badge text-secondary" style="background-color: hsla(0, 0%, 85%, 1.00);">Unknown</span>'))));
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                // empty complate order
                echo '';
            }
            ?>
        </div>
    </div>


    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {

            $("#refreshBtn").click(function () {
                $.ajax({
                    url: "myorder.php",
                    type: "GET",
                    success: function (data) {
                        $("#ordersTable").html($(data).find("#ordersTable").html());
                    },
                    error: function () {
                        alert("Unable to refresh orders. Please try again.");
                    }
                });
            });

            $(document).on("click", ".cancelOrder", function () {
                let orderId = $(this).data("id");
                if (confirm("Are you sure you want to cancel this order?")) {
                    $.ajax({
                        url: "./partials/cancel_order.php",
                        type: "POST",
                        data: { order_id: orderId },
                        success: function (response) {
                            alert(response);
                            $("#refreshBtn").click();
                        }
                    });
                }
            });

            $("#printBtn").click(function () {
                window.print();
            });
        });
    </script>
</body>

</html>