<?php require "slider.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php include "links/icons.html"; ?>

    <!-- jQuery & Validation -->
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
            margin: 30px auto;
            max-width: 600px;
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

        .main-box {
            background-color: #ffffffff;
            border-radius: 25px;
        }

        .card-body {
            background-color: rgba(251, 251, 251, 1)
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            padding: 20px 0;
            background-color: #fff;
        }
    </style>
</head>

<body>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-square-plus" id="1"></i> Add Category</h1>
            <div class="user-profile">
            </div>
        </div>

        <!-- Form Card -->

        <div class="main-box">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Category Form</h5>
                        </div>
                        <div class="card-body">
                            <form id="categoryForm" method="post" action="partials/_categories_add.php"
                                enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="categoryname" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="categoryname" id="categoryname"
                                        placeholder="Enter category name">
                                </div>

                                <div class="mb-3">
                                    <label for="categoryimage" class="form-label">Category Image</label>
                                    <input type="file" class="form-control" name="categoryimage" id="categoryimage">
                                </div>

                                <div class="mb-3">
                                    <label for="categorydesc" class="form-label">Description</label>
                                    <textarea class="form-control" name="categorydesc" id="categorydesc" rows="3"
                                        placeholder="Write something..."></textarea>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="category_list.php" id="resetBtn" class="btn btn-danger">
                                        <i class="fa-solid fa-xmark"></i> Close
                                    </a>
                                    &nbsp;
                                    <button type="submit" name="insert" class="btn btn-success">
                                        <i class="fa-solid fa-plus"></i> Add Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
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
                        extension: "jpg|jpeg|png"
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
                        minlength: "Minimum 2 characters required"
                    },
                    categoryimage: {
                        required: "Please upload an image",
                        extension: "Only JPG, JPEG, or PNG files allowed"
                    },
                    categorydesc: {
                        required: "Please enter a description",
                        minlength: "Minimum 7 characters",
                        maxlength: "Maximum 100 characters"
                    }
                },
                errorElement: "div",
                errorPlacement: function (error, element) {
                    error.addClass("error");
                    error.insertAfter(element);
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>