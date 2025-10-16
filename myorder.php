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
    </style>
</head>

<body>
    <?php include "header.php"; ?>

    <div class="order-container">
        <div class="order-header-bar">
            <h4 class="m-0">My Orders</h4>
            <div>
                <button class="btn-action me-3" id="refreshBtn" title="Refresh Orders">
                    <i class="fa-solid fa-arrow-rotate-right fa-spin"></i>
                </button>
                <button class="btn-action" id="printBtn" title="Print Orders">
                    <i class="fa-solid fa-print"></i>
                </button>
            </div>
        </div>

        <div id="ordersTable">
            <?php
            $query = "SELECT * FROM orders WHERE user_id = ? ORDER BY order_id DESC";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
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
                                <tr>
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
                                            echo "—";
                                        ?>
                                    </td>
                                    <td>₹<?php echo number_format($row['total_amount'] ?? 0, 2); ?></td>
                                    <td>
                                        <i class="fa-solid fa-eye view-product" style="color: #4e349d;" data-bs-toggle="modal"
                                            data-bs-target="#productModal<?php echo $order_id; ?>" title="View Products"></i>

                                        <!-- Modal -->
                                        <div class="modal fade" id="productModal<?php echo $order_id; ?>" tabindex="-1"
                                            aria-labelledby="productModalLabel<?php echo $order_id; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success">
                                                        <h5 class="modal-title" id="productModalLabel<?php echo $order_id; ?>">
                                                            Order Products</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Static product example -->
                                                        <div class="product-row">
                                                            <img src="images/sample-product1.jpg" alt="">
                                                            <span>Name: Sample Product 1</span>
                                                            <span>Qty: 2</span>
                                                            <span>Price: ₹500</span>
                                                        </div>
                                                        <div class="product-row">
                                                            <img src="images/sample-product2.jpg" alt="">
                                                            <span>Name: Sample Product 2</span>
                                                            <span>Qty: 1</span>
                                                            <span>Price: ₹300</span>
                                                        </div>
                                                        <div class="product-row">
                                                            <img src="images/sample-product3.jpg" alt="">
                                                            <span>Name: Sample Product 3</span>
                                                            <span>Qty: 3</span>
                                                            <span>Price: ₹700</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $status = $row['order_status'];
                                        if ($status == 1)
                                            echo "<span class='badge-status bg-success'>Pending</span>";
                                        elseif ($status == 2)
                                            echo "<span class='badge-status bg-info'>Processing</span>";
                                        elseif ($status == 3)
                                            echo "<span class='badge-status bg-primary'>Shipped</span>";
                                        elseif ($status == 4)
                                            echo "<span class='badge-status bg-warning text-dark'>Delivered</span>";
                                        else
                                            echo "<span class='badge-status bg-danger'>Cancelled</span>";
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-outline-danger btn-sm">Cancel</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                echo '<p class="no-orders">You have not placed any orders yet.</p>';
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
                    url: 'myorder.php',
                    type: 'GET',
                    success: function (data) {
                        $("#ordersTable").html(data);
                    },
                    error: function () {
                        alert("Unable to refresh orders. Please try again.");
                    }
                });
            });

            $("#printBtn").click(function () {
                window.print();
            });
        });
    </script>
</body>

</html>