<?php
require "slider.php";
// error_reporting(0);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE product_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
        } else {
            echo "No product found with ID: " . htmlspecialchars($id);
            exit;
        }
    } else {
        echo "SQL preparation failed.";
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <?php include "links/icons.html"; ?>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 3px;
        }

        .card {
            border-radius: 12px;
            margin: 30px auto;
            max-width: 600px;
        }

        .main-box {
            background-color: #ffffff;
            border-radius: 25px;
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
            <h1><i class="fa-solid fa-pen-to-square"></i> Edit Product</h1>
        </div>

        <div class="main-box">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="card shadow-sm border-1">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> Product Edit</h5>
                        </div>
                        <div class="card-body">
                            <form id="productForm" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="old_image"
                                    value="<?php echo htmlspecialchars($product['product_image']); ?>">
                                <input type="hidden" name="product_id"
                                    value="<?php echo htmlspecialchars($product['product_Id']); ?>">

                                <div class="mb-3 row">
                                    <div class="col-md-6 text-center">
                                        <label class="form-label">Current Image</label><br>
                                        <?php if (!empty($product['product_image'])): ?>
                                            <img src="images/product_img/<?php echo htmlspecialchars($product['product_image']); ?>"
                                                alt="Product Image" class="img-fluid rounded" style="max-height: 100px;">
                                        <?php else: ?>
                                            <p>No image available</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="productimage" class="form-label">Update Image</label>
                                        <input type="file" class="form-control" name="productimage" id="productimage">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="productname" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="productname" id="productname"
                                        value="<?php echo htmlspecialchars($product['product_name']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="productdesc" class="form-label">Description</label>
                                    <textarea class="form-control" name="productdesc" id="productdesc"
                                        rows="3"><?php echo htmlspecialchars($product['product_desc']); ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="productprice" class="form-label">Price</label>
                                    <input type="number" class="form-control" name="productprice" id="productprice"
                                        step="0.01" value="<?php echo htmlspecialchars($product['product_price']); ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" name="category_id" id="category_id" required>
                                        <?php
                                        $catsql = "SELECT * FROM `categories`";
                                        $catresult = mysqli_query($conn, $catsql);
                                        while ($row = mysqli_fetch_assoc($catresult)) {
                                            $catId = $row['categorie_id'];
                                            $catName = $row['categorie_name'];
                                            $selected = ($product['categorie_id'] == $catId) ? 'selected' : '';
                                            echo '<option value="' . $catId . '" ' . $selected . '>' . htmlspecialchars($catName) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="product_list.php" class="btn btn-secondary">
                                        <i class="fa-solid fa-xmark"></i> Cancel
                                    </a>
                                    &nbsp;
                                    <button type="submit" name="update" class="btn btn-success">
                                        <i class="fa-solid fa-floppy-disk"></i> Update
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

    <!-- jQuery and Validation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

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
                        minlength: 7,
                        maxlength: 255
                    },
                    productprice: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    productimage: {
                        extension: "jpg|jpeg|png"
                    }
                },
                messages: {
                    productname: {
                        required: "Please enter product name",
                        minlength: "Minimum 2 characters"
                    },
                    productdesc: {
                        required: "Please enter description",
                        minlength: "Minimum 7 characters",
                        maxlength: "Maximum 255 characters"
                    },
                    productprice: {
                        required: "Please enter price",
                        number: "Enter a valid number",
                        min: "Price cannot be negative"
                    },
                    productimage: {
                        extension: "Only JPG, JPEG, PNG allowed"
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

<?php
if (isset($_POST['update'])) {
    $id = $_POST['product_id'];
    $name = $_POST['productname'];
    $desc = $_POST['productdesc'];
    $price = $_POST['productprice'];
    $category_id = $_POST['category_id']; // Added category_id for update
    $oldImage = $_POST['old_image'];

    $newImageName = $oldImage;

    if (isset($_FILES['productimage']) && $_FILES['productimage']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['productimage']['tmp_name'];
        $fileName = basename($_FILES['productimage']['name']);

        $uploadDir = 'images/';
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $newImageName = $fileName;
        } else {
            echo "<script>alert('Image upload failed. Keeping old image.');</script>";
        }
    }

    // Update query includes categorie_id now
    $stmt = mysqli_prepare($conn, "UPDATE product SET product_name=?, product_desc=?, product_price=?, product_image=?, categorie_id=? WHERE product_id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssdsii", $name, $desc, $price, $newImageName, $category_id, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<script>alert('Product updated successfully!');window.location.href='product_list.php';</script>";
        exit();
    } else {
        echo "Failed to update product.";
    }
}
?>