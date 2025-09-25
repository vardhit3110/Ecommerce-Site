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
            <h1><i class="fa-solid fa-table-layout"></i> Category List</h1>
            <div class="user-profile">
                <i class="fa-solid fa-layer-group fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container  -->
        <div class="content-area container-fluid py-4">
            <div class="row g-4">
                <div class="col d-flex justify-content-end">
                    <form action="category-add.php" id="categoryForm">
                        <button class="btn btn-primary" id="changePage">
                            <i class="fa-solid fa-plus"></i> Add Category
                        </button>
                    </form>
                </div>
                <!-- category select  -->
                <div class="">
                    <!-- <div class="col-lg-7 col-md-8"> -->
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Category List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered border-dark table-hover align-middle mb-0">
                                    <thead class="">
                                        <tr class="table-success border-dark">
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Category Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $stmt = mysqli_prepare($conn, "SELECT * FROM categories");
                                        if ($stmt) {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $catId = $row['categorie_id'];
                                                    $status = $row['categorie_status'];
                                                    $isActive = $status == 1;

                                                    echo '<tr>';
                                                    echo "<td>{$row['categorie_id']}</td>";
                                                    echo "<td class='text-center'><img src='images/" . htmlspecialchars($row['categorie_image']) . "' class='img-thumbnail' alt='Category Image' style='width:100px; height:auto;'></td>";
                                                    echo "<td class='desc-size'><b>Name : </b> " . htmlspecialchars($row['categorie_name']) . ".";
                                                    echo "<br><br><b>Desc : </b>" . htmlspecialchars($row['categorie_desc']) . "</td>";

                                                    /* Status toggle */
                                                    echo '<td class="text-center">
                                                    <div class="status-toggle-container">
                                                    <div class="toggle-switch ' . ($isActive ? 'active' : 'inactive') . '" onclick="toggleStatus(this, ' . $catId . ')">
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

                                                    echo "<td class='text-center'><button class='btn btn-primary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#editModal' data-id='{$row['categorie_id']}'>Edit</button>
                                                         <a href='partials/_delete_product.php?id={$row['categorie_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
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


        <!-- Add Category Modal -->
        <div class="modal fade">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="categoryForm" method="post" action="partials/_categories_add.php"
                        enctype="multipart/form-data">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="addCategoryModalLabel"><i class="fa-solid fa-layer-group"></i>
                                Add New Category</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="categoryname" class="form-label">Category Name</label>
                                <input type="text" class="form-control" name="categoryname" id="categoryname"
                                    placeholder="Enter category name" required>
                            </div>

                            <div class="mb-3">
                                <label for="categoryimage" class="form-label">Category Image</label>
                                <input type="file" class="form-control" name="categoryimage" id="categoryimage"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="categorydesc" class="form-label">Description</label>
                                <textarea class="form-control" name="categorydesc" id="categorydesc" rows="3"
                                    placeholder="Write something..." required></textarea>
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
        <script>
            $(document).ready(function () {
                $("#categoryForm").validate({
                    rules: {
                        categoryname: {
                            required: true,
                            minlength: 2
                        },
                        categoryimage: {
                            required: true,
                            accept: "image/jpeg, image/png"
                        },
                        categorydesc: {
                            required: true,
                            minlength: 7,
                            maxlength: 100
                        }
                    },
                    messages: {
                        categoryname: {
                            required: "Please enter category name",
                            minlength: "Minimum 2 characters"
                        },
                        categoryimage: {
                            required: "Please upload an image",
                            accept: "Only JPG or PNG allowed"
                        },
                        categorydesc: {
                            required: "Please enter a description",
                            minlength: "Minimum 7 characters",
                            maxlength: "Max 100 characters"
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });
        </script>

        <!-- category edit -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="box-color">

                    <div class="modal-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="modal-title mb-0" id="editModalLabel">Edit Category</h5>
                    </div>

                    <div class="modal-body ">
                        <form method="post" enctype="multipart/form-data" action="" id="categoryForm">

                            <div class="mb-3 text-center">
                                <img src="" alt="Current Image" class="img-thumbnail mb-2" style="height: 100px;">
                                <div>
                                    <label for="categoryImage" class="form-label">Change Image</label>
                                    <input class="form-control" type="file" name="category-1image" id="productImage">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryname"
                                    value="Sample Product">
                            </div>

                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="categoryDescription" name="categorydesc"
                                    rows="3">Sample description</textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" name="update" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
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


        function toggleStatus(toggleElement, catId) {
            const container = toggleElement.closest('.status-toggle-container');
            const indicator = container.querySelector('.status-indicator');
            const isCurrentlyActive = toggleElement.classList.contains('active');
            const newStatus = isCurrentlyActive ? 2 : 1;

            container.classList.add('status-updating');

            const formData = new FormData();
            formData.append('catId', catId);
            formData.append('status', newStatus);

            fetch('partials/_categoryManage.php', {
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