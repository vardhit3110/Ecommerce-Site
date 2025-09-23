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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
        crossorigin="anonymous"></script>
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
            <h1><i class="fa-solid fa-table-columns"></i> Product List</h1>
            <div class="user-profile">
                <i class="fa-solid fa-list fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container  -->
        <div class="content-area container-fluid py-4">
            <div class="row g-4">
                <!-- Left Form Container -->
                <div class="d-flex justify-content-center align-items-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="card shadow-sm border-1 h-100">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0"> Add New Product</h5>
                            </div>
                            <div class="card-body">
                                <form id="myForm" method="post" action="_product_add.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="productName" class="form-label">Name :</label>
                                        <input type="text" class="form-control" name="productname" id="productname"
                                            placeholder="Enter product name" required minlength="2">
                                    </div>

                                    <div class="mb-3">
                                        <label for="productDesc" class="form-label">Description :</label>
                                        <textarea class="form-control" name="productdesc" id="productdesc" rows="2"
                                            placeholder="Write something..." required minlength="7"></textarea>
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
                                        <label for="categoryImage" class="form-label">Category Image :</label>
                                        <input type="file" class="form-control" name="productimage" id="categoryimage"
                                            required>
                                    </div>

                                    <button type="submit" name="insert" class="btn btn-success">Add Product
                                        <!-- <i class="fa-solid fa-plus"></i>  -->
                                    </button>
                                </form>
                                <!-- category validation -->
                                <script>
                                    $(document).ready(function () {
                                        $("#myForm").validate({
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
                                                    maxlength: 100,
                                                }
                                            },
                                            messages: {
                                                categoryname: {
                                                    required: "Please enter category name",
                                                    minlength: "Your name must consist of at least 2 characters"
                                                },

                                                categoryimage: {
                                                    required: "Please select an image file.",
                                                    accept: "Only JPEG and PNG images are allowed."
                                                },

                                                categorydesc: {
                                                    required: "Please enter a description",
                                                    minlength: "Description must be at least 7 characters long",
                                                    maxlength: "Description must not exceed 100 characters"
                                                }

                                            },
                                            submitHandler: function (form) {
                                                form.submit();
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <!-- Right Table Container -->
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
                                                    echo "<td><img src='images/" . htmlspecialchars($row['categorie_image']) . "' class='img-thumbnail' alt='Category Image' style='width:100px; height:auto;'></td>";
                                                    echo "<td><b>Name : </b> " . htmlspecialchars($row['categorie_name']) . ".";
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

                                                    echo '<td><button class="btn btn-sm btn-primary me-1"><i class="fa-solid fa-pen"></i></button>
                                                            <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button></td>';
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

                                        <!-- <tr>
                                            <td>1</td>
                                            <td>
                                                <img src="images/CATEGORY_IMAGE.jpg" class="img-thumbnail"
                                                    alt="Category Image" style="width:100px; height:auto;">
                                            </td>
                                            <td class="modify-name">
                                                <b>Name :</b> Name 2.
                                                <br><br>
                                                <b>Desc :</b> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Ad laborum officiis magni eum nesciunt, nisi architecto pariatur eveniet
                                                iste odit labore soluta dignissimos molestiae numquam incidunt nulla
                                                dolore reprehenderit aut.
                                                <br><br>
                                                <b>Price :</b> ₹ 500.00
                                            </td>

                                            <td class="text-center">
                                                <div class="status-toggle-container">
                                                    <div class="toggle-switch ACTIVE_OR_INACTIVE"
                                                        onclick="toggleStatus(this, CATEGORY_ID_HERE)">
                                                        <div class="toggle-slider"></div>
                                                        <div class="toggle-text">
                                                            <span class="toggle-on">ON</span>
                                                            <span class="toggle-off">OFF</span>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="status-indicator ACTIVE_OR_INACTIVE">ACTIVE_OR_INACTIVE_TEXT</span>
                                                </div>
                                            </td>

                                            <td class="modify">
                                                <button class="btn btn-sm btn-primary me-1"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button class="btn btn-sm btn-danger"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr> -->

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