<?php
require "slider.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    header('Content-Type: application/json');

    $catId = $_POST['id'];
    $status = $_POST['status'];
    if (!is_numeric($catId) || !is_numeric($status)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $stmt = mysqli_prepare($conn, "UPDATE product SET product_status = ? WHERE product_Id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $status, $catId);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* .error {
            color: red;
            font-size: 13px;
            margin-top: 3px;
        } */
        .error {
            font-size: 12px;
            color: red;
            margin-top: 2px;
            position: relative;
        }


        .card-header {
            border-bottom: 1px solid #dee2e6;
        }

        .card {
            border-radius: 12px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn i {
            pointer-events: none;
        }

        .desc-size {
            max-width: 450px;
        }

        #box-color {
            background-color: #f8f8f8ff;
        }

        .status-toggle-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .status-indicator {
            display: inline-block;
            font-weight: 600;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .toggle-switch {
            position: relative;
            width: 40px;
            height: 20px;
            border-radius: 20px;
            background: #e5e5e5;
            cursor: pointer;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .toggle-slider {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: 2;
        }

        .toggle-text {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 4px;
            font-size: 8px;
            font-weight: bold;
        }

        .toggle-on {
            color: #2ecc71;
            opacity: 0;
        }

        .toggle-off {
            color: #e74c3c;
            opacity: 1;
        }

        .toggle-switch.active {
            background: rgba(46, 204, 113, 0.3);
        }

        .toggle-switch.active .toggle-slider {
            left: calc(100% - 18px);
            transform: rotate(360deg);
        }

        .toggle-switch.active .toggle-on {
            opacity: 1;
        }

        .toggle-switch.active .toggle-off {
            opacity: 0;
        }

        .toggle-switch.inactive {
            background: rgba(231, 76, 60, 0.3);
        }

        .toggle-switch.inactive .toggle-slider {
            left: 2px;
            transform: rotate(0);
        }

        .toggle-switch.inactive .toggle-on {
            opacity: 0;
        }

        .toggle-switch.inactive .toggle-off {
            opacity: 1;
        }

        .status-indicator.active {
            background: #2ecc71;
            color: white;
            box-shadow: 0 1px 3px rgba(46, 204, 113, 0.3);
        }

        .status-indicator.inactive {
            background: #e74c3c;
            color: white;
            box-shadow: 0 1px 3px rgba(231, 76, 60, 0.3);
        }


        .status-updating {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Alert animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .status-alert {
            animation: fadeIn 0.3s ease forwards;
        }

        .status-alert.fade-out {
            animation: fadeOut 0.3s ease forwards;
        }

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .box1 {
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-table-columns"></i> Product List</h1>
            <div class="user-profile">
                <i class="fa-solid fa-list fa-2x"></i>&nbsp;
            </div>
        </div>

        <!-- Filter Section -->
        <div class="container my-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="" class="row g-3 align-items-end position-relative" id="filterForm"
                        style="position: relative;">
                        <div class="col-md-4 position-relative">
                            <label for="category_name" class="form-label mb-1">Category Name</label>
                            <input type="text" name="category_name" id="category_name"
                                class="form-control form-control-sm" placeholder="Enter category name"
                                value="<?php echo isset($_GET['category_name']) ? htmlspecialchars($_GET['category_name']) : ''; ?>">
                            <div id="categoryError" class="error position-absolute" style="top: 70px;"></div>
                        </div>

                        <div class="col-md-4">
                            <label for="product_name" class="form-label mb-1">Product Name</label>
                            <select name="product_name" id="product_name" class="form-select form-select-sm">
                                <option value="">-- Select Product --</option>
                                <?php
                                $productQuery = mysqli_query($conn, "SELECT DISTINCT product_name FROM product ORDER BY product_name ASC");
                                while ($prod = mysqli_fetch_assoc($productQuery)) {
                                    $selected = (isset($_GET['product_name']) && $_GET['product_name'] == $prod['product_name']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($prod['product_name']) . "' $selected>" . htmlspecialchars($prod['product_name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="status" class="form-label mb-1">Status</label>
                            <select name="status" id="status" class="form-select form-select-sm">
                                <option value="">-- All --</option>
                                <option value="1" <?php echo (isset($_GET['status']) && $_GET['status'] == '1') ? 'selected' : ''; ?>>Active</option>
                                <option value="2" <?php echo (isset($_GET['status']) && $_GET['status'] == '2') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div><br>


        <!-- main container  -->
        <div class="content-area container-fluid py-4">
            <div class="row g-4">

                <form action="product-add.php">
                    <div class="col d-flex justify-content-end">
                        <button class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Add New
                        </button>
                    </div>
                </form>
                <!--  -->
                <div class="">
                    <!-- <div class="col-lg-7 col-md-8"> -->
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Product List</h5>
                        </div>
                        <div class="card-body">
                            <!-- edit from product -->

                            <div class="table-responsive">
                                <table
                                    class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                                    <thead class="">
                                        <tr class="table-success border-dark">
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Product Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $query = "SELECT * FROM product p INNER JOIN categories c ON p.categorie_id = c.categorie_id WHERE 1";
                                        $params = [];

                                        if (!empty($_GET['category_name'])) {
                                            $query .= " AND categorie_name LIKE ?";
                                            $params[] = "%" . $_GET['category_name'] . "%";
                                        }

                                        if (!empty($_GET['product_name'])) {
                                            $query .= " AND product_name = ?";
                                            $params[] = $_GET['product_name'];
                                        }

                                        if (!empty($_GET['status'])) {
                                            $query .= " AND product_status = ?";
                                            $params[] = $_GET['status'];
                                        }

                                        $stmt = mysqli_prepare($conn, $query);

                                        if ($stmt) {
                                            if (!empty($params)) {
                                                $types = str_repeat("s", count($params));
                                                mysqli_stmt_bind_param($stmt, $types, ...$params);
                                            }

                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            if (mysqli_num_rows($result)) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $productId = $row['product_Id'];
                                                    $status = $row['product_status'];
                                                    $isActive = $status == 1;

                                                    echo '<tr>';
                                                    echo "<td>{$row['product_Id']}</td>";
                                                    echo "<td class='text-center'><img src='images/product_img/" . htmlspecialchars($row['product_image']) . "' class='img-thumbnail' alt='Product Image' style='width:100px; height:auto;'></td>";
                                                    echo "<td class='desc-size'><b>Name : </b> " . htmlspecialchars($row['product_name']);
                                                    echo "<br><b>Desc : </b>" . htmlspecialchars($row['product_desc']) . "";
                                                    echo "<br><br><b>Price : </b>₹ " . number_format((float) $row['product_price']) . "</td>";
                                                    echo '<td class="text-center">
                                                        <div class="status-toggle-container">
                                                            <div class="toggle-switch ' . ($isActive ? 'active' : 'inactive') . '" onclick="toggleStatus(this, ' . $productId . ', ' . $status . ')">
                                                                <div class="toggle-slider"></div>
                                                                <div class="toggle-text">
                                                                    <span class="toggle-on">ON</span>
                                                                    <span class="toggle-off">OFF</span>
                                                                </div>
                                                            </div>
                                                            <span class="status-indicator ' . ($isActive ? 'active' : 'inactive') . '">';
                                                    echo $isActive ? 'ACTIVE' : 'INACTIVE';
                                                    echo '</span></div>
                                                    </td>';

                                                    echo "<td class='text-center'>
                                                            <a href='product-edit.php?id={$row['product_Id']}' class='btn btn-primary btn-sm'>Edit</a>&nbsp;
                                                            <a href='partials/_product_add.php?id={$row['product_Id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
                                                        </td>";
                                                    echo '</tr>';
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center text-danger'>No records found</td></tr>";
                                            }

                                            mysqli_stmt_close($stmt);
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center text-danger'>Query preparation failed</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleStatus(element, productId, currentStatus) {
            const newStatus = currentStatus == 1 ? 2 : 1;
            const willBeActive = newStatus == 1;

            element.classList.add('status-updating');

            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    action: 'update_status',
                    id: productId,
                    status: newStatus
                },
                success: function (response) {
                    element.classList.remove('status-updating');

                    if (response.success) {
                        if (willBeActive) {
                            element.classList.remove('inactive');
                            element.classList.add('active');
                            element.parentElement.querySelector('.status-indicator').textContent = 'ACTIVE';
                            element.parentElement.querySelector('.status-indicator').classList.remove('inactive');
                            element.parentElement.querySelector('.status-indicator').classList.add('active');
                        } else {
                            element.classList.remove('active');
                            element.classList.add('inactive');
                            element.parentElement.querySelector('.status-indicator').textContent = 'INACTIVE';
                            element.parentElement.querySelector('.status-indicator').classList.remove('active');
                            element.parentElement.querySelector('.status-indicator').classList.add('inactive');
                        }

                        alert('Product status updated successfully!');
                    } else {
                        alert('Product status updated successfully!'); window.location.href = "product_list.php";
                    }
                },
                error: function (xhr, status, error) {
                    element.classList.remove('status-updating');
                    alert('Error updating Product status: ' + error);
                }
            });
        }
    </script>
</body>

</html>