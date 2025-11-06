<?php
require "db_connect.php";

// Check if coupon ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Coupon ID!'); window.location.href='admin-coupons.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Fetch coupon details
$query = "SELECT * FROM coupons WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Coupon not found!'); window.location.href='admin-coupons.php';</script>";
    exit;
}

$coupon = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $promo_code = mysqli_real_escape_string($conn, $_POST['promo_code']);
    $discount = (int) $_POST['discount'];
    $min_bill_price = (float) $_POST['min_bill_price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = (int) $_POST['status'];

    $update = "UPDATE coupons SET promocode='$promo_code', discount='$discount', min_bill_price='$min_bill_price', description='$description', status='$status'
               WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Coupon updated successfully!'); window.location.href='admin-coupons.php';</script>";
    } else {
        echo "<script>alert('Error updating coupon!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Coupon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square"></i> Edit Coupon</h4>
                    <a href="admin-coupons.php" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>

                <form method="POST">
                    <div class="row g-3">
                        <!-- Promo Code -->
                        <div class="col-md-6">
                            <label for="promo_code" class="form-label fw-semibold">Promo Code</label>
                            <input type="text" id="promo_code" name="promo_code" class="form-control"
                                value="<?php echo htmlspecialchars($coupon['promocode']); ?>" required>
                        </div>

                        <!-- Discount -->
                        <div class="col-md-6">
                            <label for="discount" class="form-label fw-semibold">Discount (%)</label>
                            <input type="number" id="discount" name="discount" class="form-control"
                                value="<?php echo htmlspecialchars($coupon['discount']); ?>" min="1" max="100" required>
                        </div>

                        <!-- Minimum Bill Price -->
                        <div class="col-md-6">
                            <label for="min_bill_price" class="form-label fw-semibold">Minimum Bill Price (₹)</label>
                            <input type="number" id="min_bill_price" name="min_bill_price" class="form-control"
                                value="<?php echo htmlspecialchars($coupon['min_bill_price']); ?>" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="1" <?php if ($coupon['status'] == 1)
                                    echo "selected"; ?>>Active</option>
                                <option value="2" <?php if ($coupon['status'] == 2)
                                    echo "selected"; ?>>Inactive</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea id="description" name="description" rows="3" class="form-control"
                                required><?php echo htmlspecialchars($coupon['description']); ?></textarea>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="admin-coupons.php" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Update Coupon
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>