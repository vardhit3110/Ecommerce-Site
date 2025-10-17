<?php
require "slider.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .card {
            border-radius: 12px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .filter-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #filterForm button {
            position: absolute;
            right: 10px;
            bottom: 8px;
            width: 70px;
        }

        .view-btn {
            color: #007bff;
            cursor: pointer;
        }

        .view-btn:hover {
            color: #0056b3;
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            background: #212529;
            color: white;
        }

        .order-details-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #333;
        }
    </style>
</head>

<body>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-box"></i> Orders List</h1>
            <div class="user-profile">
                <i class="fa-solid fa-layer-group fa-2x"></i>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="container my-3">
            <div class="card filter-card">
                <div class="card-body position-relative">
                    <form method="GET" id="filterForm" class="row g-3 align-items-end position-relative">
                        <div class="col-md-4">
                            <label for="username" class="form-label mb-1">Username</label>
                            <input type="text" name="username" id="username" class="form-control form-control-sm"
                                placeholder="Enter username"
                                value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
                        </div>

                        <div class="col-md-4">
                            <label for="order_code" class="form-label mb-1">Order Code</label>
                            <input type="text" name="order_code" id="order_code" class="form-control form-control-sm"
                                placeholder="Enter order code"
                                value="<?php echo isset($_GET['order_code']) ? htmlspecialchars($_GET['order_code']) : ''; ?>">
                        </div>

                        <div class="col-md-3">
                            <label for="payment_mode" class="form-label mb-1">Payment Mode</label>
                            <select name="payment_mode" id="payment_mode" class="form-select form-select-sm">
                                <option value="">-- All --</option>
                                <option value="1" <?php echo (isset($_GET['payment_mode']) && $_GET['payment_mode'] == '1') ? 'selected' : ''; ?>>Cash On Delivery</option>
                                <option value="2" <?php echo (isset($_GET['payment_mode']) && $_GET['payment_mode'] == '2') ? 'selected' : ''; ?>>Online Payment</option>
                            </select>
                        </div>

                        <div class="col-md-1 d-flex align-items-end position-relative">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="container-fluid py-0">
            <div class="card shadow-sm border-1 h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa-solid fa-list"></i> Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                            <thead>
                                <tr class="table-success border-dark text-center">
                                    <th>Order Code</th>
                                    <th>Username</th>
                                    <th>Delivery Address</th>
                                    <th>Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Payment Status</th>
                                    <th>Status</th>
                                    <th>View Product</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT userdata.username, orders.* FROM userdata JOIN orders ON userdata.id = orders.user_id WHERE 1";
                                $params = [];

                                if (!empty($_GET['username'])) {
                                    $query .= " AND userdata.username LIKE ?";
                                    $params[] = "%" . $_GET['username'] . "%";
                                }

                                if (!empty($_GET['order_code'])) {
                                    $query .= " AND orders.order_code LIKE ?";
                                    $params[] = "%" . $_GET['order_code'] . "%";
                                }

                                if (!empty($_GET['payment_mode'])) {
                                    $query .= " AND orders.payment_mode = ?";
                                    $params[] = $_GET['payment_mode'];
                                }

                                $query .= " ORDER BY orders.order_id DESC";

                                $stmt = mysqli_prepare($conn, $query);
                                if ($stmt) {
                                    if (!empty($params)) {
                                        $types = str_repeat("s", count($params));
                                        mysqli_stmt_bind_param($stmt, $types, ...$params);
                                    }
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $payment_mode = $row['payment_mode'];
                                            $payment_status = $row['payment_status'];

                                            $payMode = ($payment_mode == 1) ? "Cash On Delivery" : (($payment_mode == 2) ? "Online Payment" : "Unknown");
                                            $payStatus = "";

                                            if ($payment_status == 1) {
                                                $payStatus = '<span style="background-color: #ffc107; color: #000; padding: 2px 6px; border-radius: 4px; font-size: 12px;">Pending</span>';
                                            } elseif ($payment_status == 2) {
                                                $payStatus = '<span style="background-color: #28a745; color: #fff; padding: 2px 6px; border-radius: 4px; font-size: 12px;">Success</span>';
                                            } elseif ($payment_status == 3) {
                                                $payStatus = '<span style="background-color: #dc3545; color: #fff; padding: 2px 6px; border-radius: 4px; font-size: 12px;">Failed</span>';
                                            } else {
                                                $payStatus = '<span style="background-color: #6c757d; color: #fff; padding: 2px 6px; border-radius: 4px; font-size: 12px;">Unknown</span>';
                                            }

                                            echo "<tr class='text-center'>
                                                <td>{$row['order_code']}</td>
                                                <td>{$row['username']}</td>
                                                <td title='{$row['delivery_address']}'>{$row['delivery_address']}</td>
                                                <td>₹" . number_format($row['total_amount'], 2) . "</td>
                                                <td>{$payMode}</td>
                                                <td>{$payStatus}</td>
                                                <td>--</td>
                                                <td><i class='fa-solid fa-eye view-btn' data-bs-toggle='modal' data-bs-target='#orderDetailsModal'></i></td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center text-danger'>No records found</td></tr>";
                                    }
                                    mysqli_stmt_close($stmt);
                                } else {
                                    echo "<tr><td colspan='8' class='text-center text-danger'>Query preparation failed</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <!-- Static Popup Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-receipt"></i> Order Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="order-details-card">
                        <div class="row g-3">
                            <div class="col-md-4 text-center">
                                <img src="images/product_img/Product is Empty1.png" class="product-img mb-2"
                                    alt="Product">
                                <p class="fw-bold mb-0">Margherita Pizza</p>
                                <small>Qty: 2 | Price: ₹299 each</small>
                            </div>
                            <div class="col-md-8">
                                <p><span class="info-label">Order Code:</span> ORD123456</p>
                                <p><span class="info-label">Order Date:</span> 15 Oct 2025</p>
                                <p><span class="info-label">Shipping Charge:</span> ₹50</p>
                                <p><span class="info-label">Order Status:</span> Delivered</p>
                                <p><span class="info-label">Delivery Address:</span> 123, Green Street, Mumbai</p>
                                <p><span class="info-label">Payment Mode:</span> Online Payment</p>
                                <p><span class="info-label">Payment Status:</span> Success</p>
                                <p><span class="info-label">Total Amount:</span> ₹648</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>