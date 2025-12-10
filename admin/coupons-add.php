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
    <link rel="stylesheet" href="assets/coupons-add.css">
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