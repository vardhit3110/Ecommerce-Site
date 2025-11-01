<?php
include "db_connect.php";

if (isset($_POST['insert'])) {
    $product_name = trim($_POST['productname']);
    $product_desc = trim($_POST['productdesc']);
    $product_price = trim($_POST['productprice']);
    $category_id = trim($_POST['categoryid']);

    // main product upload
    if (isset($_FILES['productimage']) && $_FILES['productimage']['error'] == 0) {
        $path = $_FILES['productimage']['name'];
        $tmp_name = $_FILES['productimage']['tmp_name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = $product_name . "_" . time() . "." . $ext;
        $upload_path = "../images/product_img/" . $filename;

        if (!move_uploaded_file($tmp_name, $upload_path)) {
            echo "<script>alert('Main image upload failed!');window.location.href='../product_list.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please upload the main product image!');window.location.href='../product_list.php';</script>";
        exit();
    }

    //  insert product
    $sql = "INSERT INTO product (product_name, product_desc, product_price, categorie_id, product_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiis", $product_name, $product_desc, $product_price, $category_id, $filename);
    $result = mysqli_stmt_execute($stmt);
    $product_id = mysqli_insert_id($conn);

    // multiple image upload
    if ($result && isset($_FILES['multipleimages']['name'][0]) && !empty($_FILES['multipleimages']['name'][0])) {
        $total_files = count($_FILES['multipleimages']['name']);
        $gallery_folder = "../images/product_gallery/";

        for ($i = 0; $i < $total_files; $i++) {
            $tmp_name = $_FILES['multipleimages']['tmp_name'][$i];
            $original_name = $_FILES['multipleimages']['name'][$i];
            $ext = pathinfo($original_name, PATHINFO_EXTENSION);
            $multi_filename = $product_name . "_" . time() . "_$i." . $ext;
            $multi_upload_path = $gallery_folder . $multi_filename;

            if (move_uploaded_file($tmp_name, $multi_upload_path)) {
                $insertImg = "INSERT INTO product_images (product_id, image_path) VALUES (?, ?)";
                $stmtImg = mysqli_prepare($conn, $insertImg);
                mysqli_stmt_bind_param($stmtImg, "is", $product_id, $multi_filename);
                mysqli_stmt_execute($stmtImg);
            }
        }
    }

    if ($result) {
        echo "<script>alert('Product Added Successfully with Multiple Images!');window.location.href='../product_list.php';</script>";
    } else {
        echo "<script>alert('Product Not Inserted!');window.location.href='../product_list.php';</script>";
    }
}
?>