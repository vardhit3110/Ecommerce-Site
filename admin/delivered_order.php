<?php
require "slider.php";
include "db_connect.php";
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
    <link rel="stylesheet" href="assets/delivered_order.css">
</head>

<body>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-box"></i> Delivered Order</h1>
            <div class="user-profile">
                <i class="fa-solid fa-layer-group fa-2x"></i>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="container my-3">
            <div class="card filter-card">
                <div class="card-body">
                    <form method="GET" id="filterForm" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">Username</label>
                            <input type="text" name="username" class="form-control form-control-sm"
                                value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>"
                                placeholder="Enter username">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label mb-1">Order Id</label>
                            <input type="text" name="order_code" class="form-control form-control-sm"
                                value="<?php echo isset($_GET['order_code']) ? htmlspecialchars($_GET['order_code']) : ''; ?>"
                                placeholder="Enter Order Id">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label mb-1">Payment Mode</label>
                            <select name="payment_mode" class="form-select form-select-sm">
                                <option value="">-- All --</option>
                                <option value="1" <?php echo (isset($_GET['payment_mode']) && $_GET['payment_mode'] == '1') ? 'selected' : ''; ?>>Cash On Delivery</option>
                                <option value="2" <?php echo (isset($_GET['payment_mode']) && $_GET['payment_mode'] == '2') ? 'selected' : ''; ?>>Online Payment</option>
                            </select>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="container-fluid py-0">
            <div class="card shadow-sm border-1 h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa-solid fa-list"></i> Delivered Order</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                            <thead>
                                <tr class="table-success border-dark text-center">
                                    <th>Order Id</th>
                                    <th>Username</th>
                                    <th>Delivery Address</th>
                                    <th>Amount</th>
                                    <th>Order Status</th>
                                    <th>Payment Mode</th>
                                    <th>Payment Status</th>
                                    <th>View Product</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_data = 8;
                                $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
                                $offset = ($page - 1) * $total_data;

                                $query = "SELECT userdata.username, orders.* FROM userdata JOIN orders ON userdata.id = orders.user_id WHERE orders.order_status='4'";
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

                                $query .= " ORDER BY orders.order_id DESC LIMIT $offset, $total_data";

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
                                            $order_status = $row['order_status'];
                                            $payment_mode = $row['payment_mode'];
                                            $payment_status = $row['payment_status'];

                                            /* order status */
                                            $orderMode = ($order_status == 1)
                                                ? '<span class="badge text-warning" style="background-color: hsla(43, 100%, 95%, 1.00);">Pending</span>'
                                                : (($order_status == 2)
                                                    ? '<span class="badge text-primary" style="background-color: hsla(200, 85%, 92%, 1.00);">Processing</span>'
                                                    : (($order_status == 3)
                                                        ? '<span class="badge" style="background-color: hsla(260, 70%, 92%, 1.00); color: purple;">Shipped</span>'
                                                        : (($order_status == 4)
                                                            ? '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Delivered</span>'
                                                            : (($order_status == 5)
                                                                ? '<span class="badge text-danger" style="background-color: hsla(0, 75%, 92%, 1.00);">Cancelled</span>'
                                                                : '<span class="badge text-secondary" style="background-color: hsla(0, 0%, 85%, 1.00);">Unknown</span>'))));


                                            /* payment mode */
                                            $payMode = ($payment_mode == 1)
                                                ? '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Cash On Delivery</span>'
                                                : (($payment_mode == 2)
                                                    ? '<span class="badge text-primary" style="background-color: hsla(200, 85%, 92%, 1.00);">Online Payment</span>'
                                                    : '<span class="badge text-secondary" style="background-color: hsla(0, 0%, 88%, 1.00);">Unknown</span>');

                                            /* payment status */
                                            $payStatus = ($payment_status == 1)
                                                ? '<span class="badge text-warning" style="background-color: hsla(43, 100%, 95%, 1.00);">Pending</span>'
                                                : (($payment_status == 2)
                                                    ? '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Success</span>'
                                                    : (($payment_status == 3)
                                                        ? '<span class="badge text-danger" style="background-color: hsla(3, 60%, 93%, 1.00);">Failed</span>'
                                                        : '<span class="badge text-secondary" style="background-color: hsla(0, 0%, 88%, 1.00);">Unknown</span>'));

                                            echo "<tr class='text-center'>
                                                <td>{$row['order_code']}</td>
                                                <td>{$row['username']}</td>
                                                <td>{$row['delivery_address']}</td>
                                                <td>₹" . number_format($row['total_amount'], 2) . "</td>
                                                 <td>{$orderMode}</td>
                                                <td>{$payMode}</td>
                                                <td>{$payStatus}</td>
                                                <td><i class='fa-solid fa-eye view-btn' data-id='{$row['order_id']}' data-bs-toggle='modal' data-bs-target='#orderDetailsModal'></i></td>
                                                <td><i class='fa-solid fa-square-up-right update-status-btn' data-id='{$row['order_id']}' data-username='{$row['username']}' data-ordercode='{$row['order_code']}' data-bs-toggle='modal' data-bs-target='#statusModal'></i></td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9' class='text-center text-danger'>No records found</td></tr>";
                                    }
                                    mysqli_stmt_close($stmt);
                                }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <?php
                        $sql = "SELECT COUNT(*) AS total FROM orders WHERE order_status='4'AND payment_status='2'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $total_delivered = $row['total'];
                        $total_page = ceil($total_delivered / $total_data);

                        $start = ($page - 1) * $total_data + 1;
                        $end = min($page * $total_data, $total_delivered);

                        if ($total_delivered > 0) {
                            echo '<div class="d-flex justify-content-between align-items-center flex-wrap mt-3">';

                            echo "<div class='pagination-info mb-0'>Showing $start to $end of $total_delivered entries</div>";
                            echo '<ul class="pagination mb-0">';

                            // Prev button
                            if ($page > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">« Prev</a></li>';
                            } else {
                                echo '<li class="page-item disabled"><a class="page-link" href="#">« Prev</a></li>';
                            }

                            // Dynamic pages with ellipses
                            $visiblePages = 1;
                            $startPage = max(1, $page - $visiblePages);
                            $endPage = min($total_page, $page + $visiblePages);

                            if ($startPage > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                if ($startPage > 2)
                                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                            }

                            for ($i = $startPage; $i <= $endPage; $i++) {
                                $active = ($i == $page) ? 'active' : '';
                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }

                            if ($endPage < $total_page) {
                                if ($endPage < $total_page - 1)
                                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $total_page . '">' . $total_page . '</a></li>';
                            }

                            // Next button
                            if ($page < $total_page) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next »</a></li>';
                            } else {
                                echo '<li class="page-item disabled"><a class="page-link" href="#">Next »</a></li>';
                            }

                            echo '</ul>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fa-solid fa-arrows-rotate"></i> Update Order Status</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select New Status :- </label>
                        <div class="d-flex align-items-center">

                            <select id="newStatus" class="form-select">
                                <option value="">-- Select Status --</option>
                                <option value="1">Pending</option>
                                <option value="2">Processing</option>
                                <option value="3">Shipped</option>
                                <option value="4">Delivered</option>
                                <option value="5">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Username:</strong> <span id="statusUsername"></span></p>
                    <p><strong>Order ID:</strong> <span id="statusOrderId"></span></p>

                    <div class="text-center">
                        <button id="updateStatusBtn" class="btn btn-success">
                            <i class="fa-solid fa-floppy-disk"></i> Update Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white"><i class="fa-solid fa-receipt"></i> Order Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="orderDetailsBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-dark"></div>
                        <p class="mt-2">Loading order details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Open Status Modal with data
        $(document).on('click', '.update-status-btn', function () {
            let username = $(this).data('username');
            let orderCode = $(this).data('ordercode');
            let orderId = $(this).data('id');

            $('#statusUsername').text(username);
            $('#statusOrderId').text(orderCode);
            $('#updateStatusBtn').data('id', orderId);
        });

        // Update Status
        $('#updateStatusBtn').click(function () {
            let orderId = $(this).data('id');
            let newStatus = $('#newStatus').val();

            if (newStatus === "") {
                alert("Please select a status first.");
                return;
            }

            $.ajax({
                url: './partials/update_order_status.php',
                type: 'POST',
                data: { order_id: orderId, status: newStatus },
                success: function (response) {
                    alert(response);
                    location.reload();
                },
                error: function () {
                    alert("Error updating status.");
                }
            });
        });

        $(document).on('click', '.view-btn', function () {
            let orderId = $(this).data('id');
            $('#orderDetailsBody').html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-dark"></div>
                    <p class="mt-2">Loading order details...</p>
                </div>
            `);
            $.ajax({
                url: 'fetch_order_details.php',
                type: 'POST',
                data: { order_id: orderId },
                success: function (response) {
                    $('#orderDetailsBody').html(response);
                },
                error: function () {
                    $('#orderDetailsBody').html('<p class="text-danger text-center">Error loading details.</p>');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>