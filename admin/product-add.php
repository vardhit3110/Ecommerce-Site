<?php require "slider.php"; ?>
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
    <link rel="stylesheet" href="assets/product-add.css">
</head>

<body>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-square-plus"></i> Add Product</h1>
            <div class="user-profile">
            </div>
        </div>

        <!-- Form Card -->

        <div class="card shadow-sm border-0">
            <div class="p-2">
                <h5 class="mb-0"><i class="fa-solid fa-layer-group"></i> Product Form</h5>
            </div>
            <div class="card-body">
                <form id="productForm" method="post" action="partials/_product_add.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="productname" class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="productname" id="productname"
                            placeholder="Enter product name">
                    </div>

                    <div class="mb-3">
                        <label for="productdesc" class="form-label">Description</label>
                        <textarea class="form-control" name="productdesc" id="productdesc" rows="3"
                            placeholder="Write product description..."></textarea>
                    </div>

                    <!-- Price & Category in same row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="productprice" class="form-label">Price (₹)</label>
                            <input type="number" class="form-control" name="productprice" id="productprice"
                                placeholder="Enter price" step="0.01" min="0">
                        </div>

                        <div class="col-md-6">
                            <label for="categoryid" class="form-label">Category</label>
                            <select class="form-select" name="categoryid" id="categoryid">
                                <option hidden disabled selected value>-- Select Category --</option>
                                <?php
                                require "db_connect.php";
                                $catsql = "SELECT * FROM `categories`";
                                $catresult = mysqli_query($conn, $catsql);
                                while ($row = mysqli_fetch_assoc($catresult)) {
                                    echo '<option value="' . $row['categorie_id'] . '">' . htmlspecialchars($row['categorie_name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 d-flex gap-3 flex-wrap">
                        <div class="flex-fill">
                            <label for="productimage" class="form-label">Main Product Image</label>
                            <input type="file" class="form-control" name="productimage" id="productimage" required>
                            <small class="text-muted" style="font-size: 11px;">* Main thumbnail image</small>
                        </div>

                        <div class="flex-fill">
                            <label for="multipleimages" class="form-label">Additional Images</label>
                            <input type="file" class="form-control" name="multipleimages[]" id="multipleimages"
                                multiple>
                            <small class="text-danger" style="font-size: 11px;">* You can select multiple images</small>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-end">
                        <a href="product_list.php" class="btn btn-danger me-2">
                            <i class="fa-solid fa-xmark"></i> Cancel
                        </a>
                        <button type="submit" name="insert" class="btn btn-success">
                            <i class="fa-solid fa-plus"></i> Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#productForm").validate({
                    rules: {
                        productname: {
                            required: true,
                            minlength: 2
                        },
                        productdesc: {
                            required: true,
                            minlength: 10,
                            maxlength: 300
                        },
                        productprice: {
                            required: true,
                            number: true,
                            min: 0.01
                        },
                        categoryid: {
                            required: true
                        },
                        productimage: {
                            required: true,
                            extension: "jpg|jpeg|png"
                        }
                    },
                    messages: {
                        productname: {
                            required: "Please enter product name",
                            minlength: "Minimum 2 characters required"
                        },
                        productdesc: {
                            required: "Please enter product description",
                            minlength: "Minimum 10 characters required",
                            maxlength: "Maximum 300 characters allowed"
                        },
                        productprice: {
                            required: "Please enter product price",
                            number: "Please enter a valid number",
                            min: "Price must be greater than 0"
                        },
                        categoryid: {
                            required: "Please select a category"
                        },
                        productimage: {
                            required: "Please upload a product image",
                            extension: "Only JPG, JPEG, or PNG files allowed"
                        }
                    },
                    errorElement: "div",
                    errorPlacement: function (error, element) {
                        error.addClass("error text-danger mt-1");
                        error.insertAfter(element);
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });
        </script>
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