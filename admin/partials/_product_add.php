<?php
include "db_connect.php";

if (isset($_POST['insert'])) {
    $product_name = trim($_POST['productname']);
    $product_desc = trim($_POST['productdesc']);
    $product_price = trim($_POST['productprice']);
    $category_id = trim($_POST['categoryid']);


    // Check duplicate
    // $check_productName = "SELECT * FROM product WHERE product_name = ?";
    // $stmt = mysqli_prepare($conn, $check_productName);
    // mysqli_stmt_bind_param($stmt, "s", $product_name);
    // mysqli_stmt_execute($stmt);
    // $result_product = mysqli_stmt_get_result($stmt);

    // if (mysqli_num_rows($result_product) > 0) {
    //     echo "<script>alert('Product Already Added!');window.location.href='../product_list.php';</script>";
    //     exit();
    // }

    // Image upload
    if (isset($_FILES['productimage']) && $_FILES['productimage']['error'] == 0) {
        $path = $_FILES['productimage']['name'];
        $tmp_name = $_FILES['productimage']['tmp_name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = $product_name . "_" . time() . "." . $ext;
        $upload_path = "../images/product_img/" . $filename;

        if (!move_uploaded_file($tmp_name, $upload_path)) {
            echo "<script>alert('Failed to upload image.');window.location.href='../product_list.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please upload a valid image.');window.location.href='../product_list.php';</script>";
        exit();
    }

    // Insert product query
    $sql = "INSERT INTO product (product_name, product_desc, product_price, categorie_id, product_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssiis", $product_name, $product_desc, $product_price, $category_id, $filename);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Product Added Successfully!');window.location.href='../product_list.php';</script>";
    } else {
        echo "<script>alert('Product Not Inserted!');window.location.href='../product_list.php';</script>";
    }
}


/* product edit */


// if (isset($_POST['update'])) {
//     $product_id = trim($_POST['productId']);
//     $product_name = trim($_POST['productName']);
//     $product_desc = trim($_POST['productDesc']);
//     $product_price = trim($_POST['productPrice']);
//     $category_id = trim($_POST['categoryId']);
//     $old_image = trim($_POST['old_image']);

//     $filename = $old_image;

//     if (isset($_FILES['productimage']) && $_FILES['productimage']['error'] == 0) {
//         $path = $_FILES['productimage']['name'];
//         $tmp_name = $_FILES['productimage']['tmp_name'];
//         $ext = pathinfo($path, PATHINFO_EXTENSION);
//         $filename = $product_name . "_" . time() . "." . $ext;
//         $upload_path = "../images/product_img/" . $filename;

//         if (!move_uploaded_file($tmp_name, $upload_path)) {
//             echo "<script>alert('Failed to upload new image.');window.location.href='../product_list.php';</script>";
//             exit();
//         }

//         if (!empty($old_image) && file_exists("../images/product_img/" . $old_image)) {
//             unlink("../images/product_img/" . $old_image);
//         }
//     }

//     // Update query
//     $sql = "UPDATE product SET product_name = ?, product_desc = ?, product_price = ?, categorie_id = ?, product_image = ? WHERE product_Id = ?";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "ssiisi", $product_name, $product_desc, $product_price, $category_id, $filename, $product_id);
//     $result = mysqli_stmt_execute($stmt);

//     if ($result) {
//         echo "<script>alert('Product Updated Successfully!');window.location.href='../product_list.php';</script>";
//     } else {
//         echo "<script>alert('Product Not Updated!');window.location.href='../product_list.php';</script>";
//     }
// }



/* delete product */
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE product_id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location : ../product_list.php");
            exit();
        } else {
            echo "<script>alert('Product Not Deleted');window.location.href='../product_list.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='../product_list.php';</script>";
    }
}
?>

