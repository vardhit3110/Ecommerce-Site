<?php
require "slider.php";
require "db_connect.php";
$query = "SELECT * FROM coupons ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --accent: #7209b7;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background-color: white;
            border-radius: 20px;
            max-width: 100%;
            overflow-x: auto;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 600px;

        }

        .date {
            color: #757575ff;
            font-size: 12px;
        }

        td {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pagination {
            display: flex;
            list-style: none;
            justify-content: flex-end;
            padding-left: 0;
        }

        .page-item {
            margin: 0 4px;
        }

        .page-link {
            display: block;
            padding: 8px 12px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            cursor: default;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            cursor: default;
        }

        .page-link:hover {
            background-color: #e9ecef;
        }

        .disabled:hover {
            cursor: not-allowed;
        }

        .pagination-info {
            font-size: 14px;
            color: #333;
            text-align: right;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .desc-size {
                max-width: 100% !important;
            }

            .card-body {
                padding: 10px;
            }
        }

        .card {
            border-radius: 10px;
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
        }

        .btn-outline-success:hover,
        .btn-outline-danger:hover {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-tags"></i> Coupon Management </h1>
            <div class="user-profile">
                <i class="fa-solid fa-receipt fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <div class="container py-5">
            <div class="card shadow border-0">
                <div class="card-body">
                    <!-- Header Section -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                        <h4 class="fw-bold mb-3 mb-md-0">
                            <i class="fa-solid fa-tag"></i> Coupons
                        </h4>
                        <form action="coupons-add.php">
                            <button class="btn btn-primary">
                                <i class="fa-solid fa-plus"></i> Add New Coupon
                            </button>
                        </form>
                    </div>

                    <!-- Table Section -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID</th>
                                    <th>Promo Code</th>
                                    <th>Discount</th>
                                    <th>Min Bill Price</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        if ($row['status'] == 1) {
                                            $statusBadge = '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Active</span>';
                                        } elseif ($row['status'] == 2) {
                                            $statusBadge = '<span class="badge text-danger" style="background-color: hsla(0, 75%, 92%, 1.00);">Inactive</span>';
                                        } else {
                                            $statusBadge = '<span class="badge text-secondary" style="background-color: hsla(0, 0%, 85%, 1.00);">Unknown</span>';
                                        }
                                        echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td><span class='fw-semibold text-uppercase'>{$row['promocode']}</span></td>
                                    <td>{$row['discount']}%</td>
                                    <td>₹{$row['min_bill_price']}</td>
                                    <td>$statusBadge</td>
                                    <td>{$row['description']}</td>
                                    <td>" . date('Y-m-d h:i A', strtotime($row['creat_time'])) . "</td>
                                    <td>
                                        <a href='coupon-edit.php?id={$row['id']}' class='btn btn-sm btn-outline-primary me-1'>
                                            <i class='bi bi-pencil-square'></i> Edit
                                        </a>
                                        <a href='./partials/_coupon-delete.php?id={$row['id']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Are you sure you want to delete this coupon?');\">
                                            <i class='bi bi-trash'></i> Delete
                                        </a>
                                    </td>
                                </tr>";
                                    }
                                } else {
                                    echo "<tr>
                                    <td class='text-danger' colspan='8'>No Coupons Found</td>
                                  </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>