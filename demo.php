<?php
require "slider.php";
require "conn.php"; // <-- Make sure DB connection is established here
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- [HEAD Section remains unchanged, same as your provided code] -->
    <!-- ... head content ... -->
</head>

<body>
    <div class="main-content">
        <!-- [Header and Filter Form remains unchanged] -->
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
                            <button type="submit" class="btn btn-sm btn-primary w-100">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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

                <!-- Product List Card -->
                <div class="">
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Product List</h5>
                        </div>
                        <div class="card-body">
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
                                        // Start building dynamic SQL
                                        $query = "SELECT * FROM product WHERE 1";
                                        $params = [];

                                        if (!empty($_GET['category_name'])) {
                                            $query .= " AND product_category LIKE ?";
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
                                                    echo "<td class='desc-size'><b>Name : </b> " . htmlspecialchars($row['product_name']) . ".";
                                                    echo "<br><b>Desc : </b>" . htmlspecialchars($row['product_desc']) . "";
                                                    echo "<br><br><b>Price : </b>₹ " . number_format((float) $row['product_price']) . "</td>";

                                                    echo '<td class="text-center">
                                                        <div class="status-toggle-container">
                                                            <div class="toggle-switch ' . ($isActive ? 'active' : 'inactive') . '" onclick="toggleStatus(this, ' . $productId . ')">
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

    <!-- JS (unchanged) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // [toggleStatus JS function remains unchanged]
        // ...
    </script>
</body>

</html>
