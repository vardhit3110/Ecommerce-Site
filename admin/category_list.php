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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .error {
            color: red;
            font-size: 14px;
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
        <!-- main container -->
        <div class="content-area container-fluid py-4">
            <div class="row g-4">
                <!-- Left Form Container -->
                <div class="col-lg-4 col-md-5">
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"> Add New Category</h5>
                        </div>
                        <div class="card-body">
                            <form id="myForm" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">Category Name :</label>
                                    <input type="text" class="form-control" name="categoryname" id="categoryname"
                                        placeholder="Enter category name" required minlength="2">
                                </div>
                                <div class="mb-3">
                                    <label for="categoryImage" class="form-label">Category Image :</label>
                                    <input type="file" class="form-control" name="categoryimage" id="categoryimage" required>
                                </div>
                                <div class="mb-3">
                                    <label for="categoryDesc" class="form-label">Description :</label>
                                    <textarea class="form-control" name="categorydesc" id="categorydesc" rows="2"
                                        placeholder="Write something..." required minlength="7"></textarea>
                                </div>
                                <button type="submit" name="insert" class="btn btn-success">
                                    <i class="fa-solid fa-plus"></i> Add Category
                                </button>
                            </form>
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
                <div class="col-lg-8 col-md-7">
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Category List</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Category Details</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><img src="" class="img-thumbnail" alt="Category Image"></td>
                                            <td>Name : ABC <br><br> Desc : Another category description here</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button class="btn btn-sm btn-danger"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><img src="" class="img-thumbnail" alt="Category Image"></td>
                                            <td>Name : ABC <br><br> Desc : Another category description here</td>
                                            <td><span class="badge bg-secondary">Inactive</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button class="btn btn-sm btn-danger"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>

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

</body>

</html>