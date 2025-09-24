<?php
require "slider.php";
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

        .error {
            color: red;
            font-size: 13px;
            margin-top: 3px;
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
    </style>

</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-table-columns"></i> Subcaterogy List</h1>
            <div class="user-profile">
                <i class="fa-solid fa-list fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container  -->
        <div class="content-area container-fluid py-4">
            <div class="row g-4">

                <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="fa-solid fa-plus"></i> Add New
                    </button>
                </div>
                <!-- Right Table Container -->
                <div class="">
                    <!-- <div class="col-lg-7 col-md-8"> -->
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Subcategory List</h5>
                        </div>
                        <div class="card-body">
                            <!-- edit from product -->

                            <div class="table-responsive">
                                <table class="table table-bordered border-dark table-hover align-middle mb-0">
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
                                        $stmt = mysqli_prepare($conn, "SELECT * FROM product");
                                        if ($stmt) {
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
                                                    echo "<br><br><b>Price : </b>₹ " . htmlspecialchars($row['product_price']) . "</td>";

                                                    /* Status toggle */
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

                                                    echo "<td><button class='btn btn-primary btn-sm me-2 editBtn' 
                                                    data-bs-toggle='modal' 
                                                    data-bs-target='#editModal' 
                                                    data-id='" . $row['product_Id'] . "' 
                                                    data-name='" . htmlspecialchars($row['product_name'], ENT_QUOTES) . "' 
                                                    data-desc='" . htmlspecialchars($row['product_desc'], ENT_QUOTES) . "' 
                                                    data-price='" . $row['product_price'] . "' 
                                                    data-category='" . $row['categorie_id'] . "' 
                                                    data-image='images/product_img/" . htmlspecialchars($row['product_image'], ENT_QUOTES) . "'>
                                                    Edit
                                                </button>
                                                         <a href='partials/.php?id={$row['product_Id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
                                                    </td>";
                                                    echo '</tr>';
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
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

    <!-- popup subcategory -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form id="categoryForm" method="post" action="partials/_product_add.php" enctype="multipart/form-data">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addCategoryModalLabel"><i class="fa-solid fa-layer-group"></i>
                            Add New Subcategory</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="productName" class="form-label">Name :</label>
                            <input type="text" class="form-control" name="productname" id="productname"
                                placeholder="Enter product name" required minlength="2">
                        </div>

                        <div class="mb-3">
                            <label for="productDesc" class="form-label">Description :</label>
                            <textarea class="form-control" name="productdesc" id="productdesc" rows="2"
                                placeholder="Write something..." required minlength="10"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="productprice" class="form-label">Price :</label>
                            <input type="text" class="form-control" name="productprice" id="productprice"
                                placeholder="Enter productprice " required minlength="2">
                        </div>

                        <div class="mb-3">
                            <label for="categoryid" class="form-label">Category:</label>
                            <select name="categoryid" id="categoryid" class="form-select" required>
                                <option hidden disabled selected value>None</option>
                                <?php
                                $catsql = "SELECT * FROM `categories`";
                                $catresult = mysqli_query($conn, $catsql);
                                while ($row = mysqli_fetch_assoc($catresult)) {
                                    $catId = $row['categorie_id'];
                                    $catName = $row['categorie_name'];
                                    echo '<option value="' . $catId . '">' . $catName . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Image :</label>
                            <input type="file" class="form-control" name="productimage" id="productimage" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="insert" class="btn btn-success">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Edit Modal -->

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="box-color">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" action="partials/_product_add.php"
                        id="editProductForm">

                        <input type="hidden" name="productid" value="...">
                        <input type="hidden" name="old_image" value="...">


                        <div class="mb-3 text-center">
                            <img id="editProductImagePreview" src="" class="img-thumbnail mb-2" style="height: 100px;">
                            <input class="form-control" type="file" name="productImage">
                        </div>

                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="productName" id="editProductName">
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control" name="productDesc" id="editProductDesc" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" class="form-control" name="productPrice" id="editProductPrice">
                        </div>

                        <div class="mb-3">
                            <label>Category</label>
                            <select class="form-select" name="categoryId" id="editProductCategory">
                                <?php
                                $catsql = "SELECT * FROM `categories`";
                                $catresult = mysqli_query($conn, $catsql);
                                while ($row = mysqli_fetch_assoc($catresult)) {
                                    echo '<option value="' . $row['categorie_id'] . '">' . $row['categorie_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).on("click", ".editBtn", function () {
            var id = $(this).data("id");
            var name = $(this).data("name");
            var desc = $(this).data("desc");
            var price = $(this).data("price");
            var category = $(this).data("category");
            var image = $(this).data("image");

            $("#editProductId").val(id);
            $("#editProductName").val(name);
            $("#editProductDesc").val(desc);
            $("#editProductPrice").val(price);
            $("#editProductCategory").val(category);
            $("#editProductImagePreview").attr("src", image);
        });

    </script>
    <!-- product validation -->
    <script>
        $(document).ready(function () {
            $("#categoryForm").validate({
                rules: {
                    productname: {
                        required: true,
                        minlength: 2
                    },
                    productdesc: {
                        required: true,
                        minlength: 10,
                        maxlength: 250
                    },
                    productprice: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 999999
                    },
                    categoryid: {
                        required: true
                    },
                    productimage: {
                        required: true,
                        accept: "image/jpeg,image/png"
                    }
                },
                messages: {
                    productname: {
                        required: "Please enter product name",
                        minlength: "Product name must be at least 2 characters"
                    },
                    productdesc: {
                        required: "Please enter a description",
                        minlength: "Description must be at least 10 characters",
                        maxlength: "Description must not exceed 250 characters"
                    },
                    productprice: {
                        required: "Please enter a price",
                        number: "Please enter a valid number",
                        min: "Price must be greater than zero",
                        max: "Price cannot exceed 999999"
                    },
                    categoryid: {
                        required: "Please select a category"
                    },
                    productimage: {
                        required: "Please upload a product image",
                        accept: "Only JPEG and PNG images are allowed"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        function showToast(message, type = 'success') {
            const toast = $('.toast');
            toast.find('.toast-body').text(message);

            if (type === 'error') {
                toast.find('.toast-header').css('background-color', '#f8d7da');
                toast.find('.toast-body').css('background-color', '#f8d7da');
            } else {
                toast.find('.toast-header').css('background-color', '#d4edda');
                toast.find('.toast-body').css('background-color', '#d4edda');
            }

            toast.toast('show');
        }


        function toggleStatus(toggleElement, productId) {
            const container = toggleElement.closest('.status-toggle-container');
            const indicator = container.querySelector('.status-indicator');
            const isCurrentlyActive = toggleElement.classList.contains('active');
            const newStatus = isCurrentlyActive ? 2 : 1;

            container.classList.add('status-updating');

            const formData = new FormData();
            formData.append('productId', productId);
            formData.append('status', newStatus);

            fetch('partials/-product_add.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {

                    if (newStatus == 1) {
                        toggleElement.classList.remove('inactive');
                        toggleElement.classList.add('active');
                        indicator.classList.remove('inactive');
                        indicator.classList.add('active');
                        indicator.textContent = 'ACTIVE';
                    } else {
                        toggleElement.classList.remove('active');
                        toggleElement.classList.add('inactive');
                        indicator.classList.remove('active');
                        indicator.classList.add('inactive');
                        indicator.textContent = 'INACTIVE';
                    }

                    showToast('Status updated successfully!');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred while updating status.', 'error');
                })
                .finally(() => {

                    container.classList.remove('status-updating');
                });
        }
    </script>
</body>

</html>