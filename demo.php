<?php require "slider.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        
        .status-active {
            color: #28a745 !important;
            font-weight: bold;
        }
        
        .status-inactive {
            color: #dc3545 !important;
            font-weight: bold;
        }
        
        .status-select {
            cursor: pointer;
            transition: all 0.3s;
            width: 120px;
            margin: 0 auto;
        }
        
        .status-select:focus {
            box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
            border-color: #80bdff;
        }
        
        .main-content {
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .content-area {
            margin-bottom: 20px;
        }
        
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
        <div class="toast-header">
            <strong class="me-auto">Notification</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body"></div>
    </div>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-table-layout"></i> Category List</h1>
            <div class="user-profile">
                <i class="fa-solid fa-layer-group fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <div class="content-area container-fluid py-4">
            <div class="row g-4">
                <!-- Left Form Container -->
                <div class="col-lg-5 col-md-6">
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"> Add New Category</h5>
                        </div>
                        <div class="card-body">
                            <form id="myForm" method="post" action="partials/_categories_add.php"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">Category Name :</label>
                                    <input type="text" class="form-control" name="categoryname" id="categoryname"
                                        placeholder="Enter category name" required minlength="2">
                                </div>
                                <div class="mb-3">
                                    <label for="categoryImage" class="form-label">Category Image :</label>
                                    <input type="file" class="form-control" name="categoryimage" id="categoryimage"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryDesc" class="form-label">Description :</label>
                                    <textarea class="form-control" name="categorydesc" id="categorydesc" rows="2"
                                        placeholder="Write something..." required minlength="7"></textarea>
                                </div>
                                <button type="submit" name="insert" class="btn btn-success">Add Category
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

                <!-- Right Table Container -->
                <div class="col-lg-7 col-md-8">
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
                                            <th class="text-center">Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        require "db_connect.php";
                                        
                                        $stmt = mysqli_prepare($conn, "SELECT * FROM categories");

                                        // Check if prepare was successful
                                        if ($stmt) {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            // Check if any rows returned
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $catId = $row['categorie_id'];
                                                    $status = $row['categorie_status'];
                                                    
                                                    echo '<tr>';
                                                    echo "<td>{$row['categorie_id']}</td>";
                                                    echo "<td><img src='images/" . htmlspecialchars($row['categorie_image']) . "' class='img-thumbnail' alt='Category Image' style='width:100px; height:auto;'></td>";
                                                    echo "<td><b>Name : </b> " . htmlspecialchars($row['categorie_name']);
                                                    echo "<br><br><b>Desc : </b>" . htmlspecialchars($row['categorie_desc']) . "</td>";
                                                    
                                                    // Status column with dropdown
                                                    echo '<td class="text-center">';
                                                    echo '<form method="POST" class="status-form">';
                                                    echo '<input type="hidden" name="catId" value="' . $catId . '">';
                                                    echo '<select name="status" class="form-select status-select" onchange="updateStatus(this, ' . $catId . ')">';
                                                    
                                                    if ($status == 1) {
                                                        echo '<option value="1" selected>Active</option>';
                                                        echo '<option value="2">Inactive</option>';
                                                    } else {
                                                        echo '<option value="1">Active</option>';
                                                        echo '<option value="2" selected>Inactive</option>';
                                                    }
                                                    
                                                    echo '</select>';
                                                    echo '</form>';
                                                    echo '</td>';
                                                    
                                                    // Action buttons
                                                    echo '<td>';
                                                    echo '<button class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></button> ';
                                                    echo '<button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>';
                                                    echo '</td>';
                                                    
                                                    echo '</tr>';
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                                            }

                                            mysqli_stmt_close($stmt); // Always good to close the statement
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
        // Function to show toast notification
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

        // Function to update status via AJAX
        function updateStatus(selectElement, catId) {
            const status = selectElement.value;
            const originalStatus = selectElement.getAttribute('data-original-value');
            
            // Update the color immediately for better UX
            updateStatusColor(selectElement, status);
            
            // Create FormData object to send via AJAX
            const formData = new FormData();
            formData.append('catId', catId);
            formData.append('status', status);
            
            // Send AJAX request
            fetch('partials/_categoryManage.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Show success message
                showToast('Status updated successfully!');
                
                // Update the original value to the new status
                selectElement.setAttribute('data-original-value', status);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while updating status.', 'error');
                
                // Revert to original value on error
                selectElement.value = originalStatus;
                updateStatusColor(selectElement, originalStatus);
            });
        }
        
        // Function to update the color of the status select element
        function updateStatusColor(selectElement, status) {
            // Remove existing color classes
            selectElement.classList.remove('status-active', 'status-inactive');
            
            // Add appropriate class based on status
            if (status == 1) {
                selectElement.classList.add('status-active');
            } else if (status == 2) {
                selectElement.classList.add('status-inactive');
            }
        }
        
        // Initialize status colors on page load
        document.querySelectorAll('.status-select').forEach(select => {
            // Store original value for potential revert
            select.setAttribute('data-original-value', select.value);
            updateStatusColor(select, select.value);
        });
    </script>
</body>

</html>