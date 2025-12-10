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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/product_list.css">
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
        <div class="card shadow border-0" id="card-body">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0"><i class="fa-solid fa-list"></i> Products</h4>
                    <a href="product-add.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center mt-0">
                        <thead class="table-success">
                            <tr>
                                <th><input type="checkbox" class="checkbox-style" id="selectAll"></th>
                                <th>Product</th>
                                <th>Description</th>
                                <th>Price</th>
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
                                        $prodDesc = $row['product_desc'];
                                        $productName = $row['product_name'];
                                        echo "<tr>";
                                        echo '<td><input type="checkbox" class="checkbox-style singleCheck"></td>';
                                        echo "<td><div class='prod-info'><img src='images/product_img/" . htmlspecialchars($row['product_image']) . "' alt='Product Image' title=$productName</div></td>";
                                        // echo "<td class='prod-details'><p title='.$prodDesc.'>" . htmlspecialchars(substr($prodDesc, 0, 110)) . "...</p></td>";
                                        echo "<td class='prod-details'><p class='hover-text'>" . htmlspecialchars(substr($prodDesc, 0, 110)) . "...<span class='tooltip-text'>$prodDesc</span></p></td>";
                                        echo "<td>₹" . number_format((float) $row['product_price'], 2) . "</td>";

                                        echo '<td>
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="status-indicator ' . ($isActive ? 'active' : 'inactive') . '">' . ($isActive ? 'Active' : 'Inactive') . '</div>
                                            <div class="toggle-switch mt-2 ' . ($isActive ? 'active' : 'inactive') . '" onclick="toggleStatus(this,' . $productId . ',' . $status . ')">
                                                <div class="toggle-slider"></div>
                                            </div>
                                        </div>
                                    </td>';

                                        echo "<td>
                                        <a href='product-edit.php?id={$row['product_Id']}' class='btn btn-sm btn-outline-primary me-2'><i class='bi bi-pencil-square'></i> Edit</a>
                                        <a href='partials/_product_add.php?id={$row['product_Id']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Are you sure you want to delete this record?')\"><i class='bi bi-trash'></i> Delete</a>
                                    </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center text-danger'>No records found</td></tr>";
                                }

                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<tr><td colspan='6' class='text-center text-danger'>Query preparation failed</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                        if (confirm("Do you want to update the category status?")) {
                            window.location.href = "product_list.php";
                        }
                    }
                },
                error: function (xhr, status, error) {
                    element.classList.remove('status-updating');
                    alert('Error updating Product status: ' + error);
                }
            });
        }

        $('#selectAll').on('change', function () {
            $('.singleCheck').prop('checked', $(this).prop('checked'));
        });

        $(document).on('change', '.singleCheck', function () {
            if (!$(this).prop('checked')) {
                $('#selectAll').prop('checked', false);
            } else if ($('.singleCheck:checked').length === $('.singleCheck').length) {
                $('#selectAll').prop('checked', true);
            }
        });
    </script>
</body>

</html>