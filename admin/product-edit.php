<?php
require "slider.php";
include "db_connect.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    $images = [];
    $imgQuery = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $id");
    while ($row = mysqli_fetch_assoc($imgQuery)) {
        $images[] = $row['image_path'];
    }
} else {
    echo "No product ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="assets/product-edit.css">
</head>

<body>

    <div class="main-content">
        <div class="header text-center mb-4">
            <h1><i class="fa-solid fa-pen-to-square"></i> Edit Product</h1>
        </div>

        <div class="main-box">
            <form id="productForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="old_image"
                    value="<?php echo htmlspecialchars($product['product_image']); ?>">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_Id']); ?>">

                <div class="row g-4">
                    <!-- left side image -->
                    <div class="col-md-6 text-center">
                        <label class="form-label mb-3 fw-bold">Current Main Image</label><br>
                        <?php if (!empty($product['product_image'])): ?>
                            <img src="images/product_img/<?php echo htmlspecialchars($product['product_image']); ?>"
                                class="img-large mb-5" style="width: 160px">
                        <?php else: ?>
                            <p>No image available</p>
                        <?php endif; ?>

                        <label class="form-label mt-3"></label>
                        <input type="file" class="form-control" name="productimage" id="productimage">
                    </div>

                    <!--Multiple Images-->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Current Gallery Images</label>
                        <div class="gallery-wrapper">
                            <?php if (!empty($images)): ?>
                                <?php foreach ($images as $img): ?>
                                    <div class="gallery-item">
                                        <img src="images/product_gallery/<?php echo htmlspecialchars($img); ?>"
                                            class="img-small">
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">No additional images yet.</p>
                            <?php endif; ?>
                        </div>

                        <label class="form-label mt-3">Upload New Gallery Images</label>
                        <input type="file" class="form-control" name="multipleimages[]" id="multipleimages" multiple>
                    </div>
                </div>
                <hr>
                <!-- product Details -->
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="productname" id="productname"
                            value="<?php echo htmlspecialchars($product['product_name']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Price (₹)</label>
                        <input type="number" class="form-control price-input" name="productprice" id="productprice"
                            step="0.01" value="<?php echo htmlspecialchars($product['product_price']); ?>">
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="productdesc" id="productdesc"
                        rows="3"><?php echo htmlspecialchars($product['product_desc']); ?></textarea>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id" required>
                            <?php
                            $catsql = "SELECT * FROM categories";
                            $catresult = mysqli_query($conn, $catsql);
                            while ($row = mysqli_fetch_assoc($catresult)) {
                                $selected = ($product['categorie_id'] == $row['categorie_id']) ? 'selected' : '';
                                echo '<option value="' . $row['categorie_id'] . '" ' . $selected . '>' . htmlspecialchars($row['categorie_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Product Discount (%)</label>
                        <input type="number" class="form-control" name="product_off" id="product_off" step="0.01"
                            value="<?php echo isset($product['product_off']) ? htmlspecialchars($product['product_off']) : '0'; ?>">
                    </div>
                </div>


                <div class="d-flex justify-content-end mt-3">
                    <a href="product_list.php" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i>
                        Cancel</a>&nbsp;
                    <button type="submit" name="update" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>
                        Update</button>
                </div>
            </form>
        </div>

        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <?php
    if (isset($_POST['update'])) {
        $id = $_POST['product_id'];
        $name = $_POST['productname'];
        $desc = $_POST['productdesc'];
        $price = $_POST['productprice'];
        $product_off = isset($_POST['product_off']) ? $_POST['product_off'] : 0;
        $category_id = $_POST['category_id'];
        $oldImage = $_POST['old_image'];
        $newImageName = $oldImage;

        if (isset($_FILES['productimage']) && $_FILES['productimage']['error'] == 0) {
            $ext = pathinfo($_FILES['productimage']['name'], PATHINFO_EXTENSION);
            $newImageName = $name . "_" . time() . "." . $ext;
            $targetPath = "images/product_img/" . $newImageName;
            move_uploaded_file($_FILES['productimage']['tmp_name'], $targetPath);
        }

        $stmt = mysqli_prepare($conn, "UPDATE product SET product_name=?, product_desc=?, product_price=?, product_image=?, categorie_id=?, product_off=? WHERE product_id=?");
        mysqli_stmt_bind_param($stmt, "ssdsiid", $name, $desc, $price, $newImageName, $category_id, $product_off, $id);

        mysqli_stmt_execute($stmt);

        // multiple image insert and update
        if (isset($_FILES['multipleimages']['name'][0]) && !empty($_FILES['multipleimages']['name'][0])) {
            $gallery_folder = "images/product_gallery/";
            $total_files = count($_FILES['multipleimages']['name']);
            for ($i = 0; $i < $total_files; $i++) {
                $tmp_name = $_FILES['multipleimages']['tmp_name'][$i];
                $original_name = $_FILES['multipleimages']['name'][$i];
                $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                $multi_filename = $name . "_" . time() . "_$i." . $ext;
                $multi_upload_path = $gallery_folder . $multi_filename;
                move_uploaded_file($tmp_name, $multi_upload_path);

                $check = mysqli_query($conn, "SELECT COUNT(*) as total FROM product_images WHERE product_id = $id");
                $row = mysqli_fetch_assoc($check);
                if ($row['total'] == 0) {
                    $insert = mysqli_prepare($conn, "INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                    mysqli_stmt_bind_param($insert, "is", $id, $multi_filename);
                    mysqli_stmt_execute($insert);
                } else {
                    $insert = mysqli_prepare($conn, "INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
                    mysqli_stmt_bind_param($insert, "is", $id, $multi_filename);
                    mysqli_stmt_execute($insert);
                }
            }
        }
        echo "<script>alert('Product updated successfully!');window.location.href='product_list.php';</script>";
        exit();
    }
    ?>
</body>

</html>