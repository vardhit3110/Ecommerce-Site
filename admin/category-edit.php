<?php
require "slider.php";
error_reporting(0);
?>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --accent: #7209b7;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            background-color: rgba(235, 235, 235, 1)
        }

        .main-box {
            background-color: #ffffffff;
            border-radius: 25px;
        }

        .card-body {
            background-color: rgba(255, 249, 249, 1)
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
            <h1><i class="fa-solid fa-pen-to-square"></i> Edit Category</h1>
            <div class="user-profile">
            </div>
        </div>

        <!-- Form Card -->

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $stmt = mysqli_prepare($conn, "SELECT * FROM categories WHERE categorie_id = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result) > 0) {
                    while ($catrow = mysqli_fetch_assoc($result)) {
                        $catName = $catrow['categorie_name'];
                        $catDesc = $catrow['categorie_desc'];
                        $catImage = $catrow['categorie_image'];
                    }
                } else {
                    echo "No category found with ID: " . htmlspecialchars($id);
                }
            } else {
                echo "Failed to prepare the SQL statement.";
            }
        } else {
            echo "No ID provided in the URL.";
        }
        ?>

        <!-- Edit Container -->
        <div class="main-box">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="card shadow-sm border-1">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> Category Edit</h5>
                        </div>
                        <div class="card-body">
                            <form id="categoryForm" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="old_image"
                                    value="<?php echo htmlspecialchars($catImage); ?>">
                                <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($id); ?>">

                                <div class="mb-3 row">
                                    <div class="col-md-6 text-center">
                                        <label class="form-label">Current Image</label><br>
                                        <?php if (!empty($catImage)): ?>
                                            <img src="images/<?php echo htmlspecialchars($catImage); ?>"
                                                alt="Category Image" class="img-fluid rounded" style="max-height: 100px;">
                                        <?php else: ?>
                                            <p>No image available</p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="categoryimage" class="form-label">Update Image</label>
                                        <input type="file" class="form-control" name="categoryimage" id="categoryimage">
                                        <small class="form-text text-muted">Choose a new image to replace the current
                                            one.</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="categoryname" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="categoryname" id="categoryname"
                                        value="<?php echo htmlspecialchars($catName); ?>"
                                        placeholder="Enter category name">
                                </div>

                                <div class="mb-3">
                                    <label for="categorydesc" class="form-label">Description</label>
                                    <textarea class="form-control" name="categorydesc" id="categorydesc" rows="3"
                                        placeholder="Write something..."><?php echo htmlspecialchars($catDesc); ?></textarea>
                                </div>
                                <hr><br>
                                <div class="d-flex justify-content-end">
                                    <a href="category_list.php" id="resetBtn" class="btn btn-secondary">
                                        <i class="fa-solid fa-xmark"></i> Cancel
                                    </a>
                                    &nbsp;
                                    <button type="submit" name="update" class="btn btn-success">
                                        <i class="fa-solid fa-floppy-disk"></i> Save
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
                        required: false,
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

<?php

if (isset($_POST['update'])) {
    $id = $_POST['category_id'];
    $name = $_POST['categoryname'];
    $desc = $_POST['categorydesc'];
    $oldImage = $_POST['old_image'];

    $newImageName = $oldImage;

    if (isset($_FILES['categoryimage']) && $_FILES['categoryimage']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['categoryimage']['tmp_name'];
        $fileName = basename($_FILES['categoryimage']['name']);

        $uploadDir = 'images/';
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $newImageName = $fileName;
        } else {
            echo "Image upload failed. Keeping old image.";
        }
    }

    //  update DB
    $stmt = mysqli_prepare($conn, "UPDATE categories SET categorie_name=?, categorie_desc=?, categorie_image=? WHERE categorie_id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $name, $desc, $newImageName, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<script>alert('Category Update Successful!');window.location.href='category_list.php';</script>";
        exit();
    } else {
        echo "Error in SQL update statement.";
    }
}
?>