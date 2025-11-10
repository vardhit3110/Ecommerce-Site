<?php
require "slider.php";
require "db_connect.php";

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
            <h1><i class="fa-solid fa-tags"></i> Add New Coupon</h1>
            <div class="user-profile">
                <i class="fa-solid fa-receipt fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <div class="container py-5">
            <div class="card shadow border-0 mb-4">
                <div class="card-body">
                    <h4 class="fw-bold mb-4"><i class="fa-solid fa-plus"></i> Add New Coupon</h4>
                    <form method="POST" action="./partials/_add_coupon.php">
                        <div class="row g-3">
                            <!-- Promo Code -->
                            <div class="col-md-6">
                                <label for="promo_code" class="form-label fw-semibold">Promo Code</label>
                                <input type="text" id="promo_code" name="promo_code" class="form-control"
                                    placeholder="Enter Promo Code (e.g., SAVE20)" required>
                            </div>

                            <!-- Discount -->
                            <div class="col-md-6">
                                <label for="discount" class="form-label fw-semibold">Discount (%)</label>
                                <input type="number" id="discount" name="discount" class="form-control"
                                    placeholder="Enter Discount %" min="1" max="100" required>
                            </div>

                            <!-- Minimum Bill Price -->
                            <div class="col-md-6">
                                <label for="min_bill_price" class="form-label fw-semibold">Minimum Bill Price
                                    (₹)</label>
                                <input type="number" id="min_bill_price" name="min_bill_price" class="form-control"
                                    placeholder="Enter Minimum Bill Amount" required>
                            </div>

                            <!-- usage_limit -->
                            <div class="col-md-6">
                                <label for="usage_limit" class="form-label fw-semibold">Usage Limit</label>
                                <input type="number" id="usage_limit" name="usage_limit" class="form-control"
                                    placeholder="Enter Usage Limit" min="1" required>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea id="description" name="description" rows="3" class="form-control"
                                    placeholder="Enter short description about this coupon..." required></textarea>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Add Coupon
                            </button>
                        </div>
                    </form>
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