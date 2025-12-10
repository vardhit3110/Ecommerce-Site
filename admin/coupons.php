<?php
require "slider.php";
require "db_connect.php";
$query = "SELECT * FROM coupons ORDER BY id";
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
    <link rel="stylesheet" href="assets/coupons.css">
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
        <!-- <div class="container py-5"> -->
        <div class="card shadow border-0" id="card-body">
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
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Promo Code</th>
                                <th>Discount</th>
                                <th>Min Bill Price</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>usage limit</th>
                                <th>used count </th>
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
                                    $no_formate = number_format($row['min_bill_price']);
                                    echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td><span class='fw-semibold text-uppercase'>{$row['promocode']}</span></td>
                                    <td>{$row['discount']}%</td>
                                    <td>₹{$no_formate}</td>
                                    <td>$statusBadge</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['usage_limit']}</td>
                                    <td>{$row['used_count']}</td>
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
        <!-- </div> -->
        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>