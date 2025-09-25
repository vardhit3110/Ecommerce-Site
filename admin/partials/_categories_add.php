<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "db_connect.php";

if (isset($_POST['insert'])) {
    $category_name = trim($_POST['categoryname']);
    $category_desc = trim($_POST['categorydesc']);

    // Check duplicate
    $check_categoryName = "SELECT * FROM categories WHERE categorie_name = ?";
    $stmt = mysqli_prepare($conn, $check_categoryName);
    mysqli_stmt_bind_param($stmt, "s", $category_name);
    mysqli_stmt_execute($stmt);
    $result_categorie = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_categorie) > 0) {
        echo "<script>alert('Category Already Added!');window.location.href='../category-add.php';</script>";
        exit();
    }

    // Image upload
    if (isset($_FILES['categoryimage']) && $_FILES['categoryimage']['error'] == 0) {
        $path = $_FILES['categoryimage']['name'];
        $tmp_name = $_FILES['categoryimage']['tmp_name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $filename = $category_name . "_" . time() . "." . $ext;
        $upload_path = "../images/" . $filename;

        if (!move_uploaded_file($tmp_name, $upload_path)) {
            echo "<script>alert('Failed to upload image.');window.location.href='../category-add.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please upload a valid image.');window.location.href='../category_list.php';</script>";
        exit();
    }

    // Insert into DB
    $sql = "INSERT INTO categories (categorie_name, categorie_desc, categorie_image) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $category_name, $category_desc, $filename);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "<script>alert('Category Added Successfully!');window.location.href='../category_list.php';</script>";
    } else {
        echo "<script>alert('Category Not Inserted!');window.location.href='../category_list.php';</script>";
    }
}

/* delete category */

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM categories WHERE categorie_id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../category_list.php");
            exit();
        } else {
            echo "<script>alert('Category Not Deleted');window.location.href='../category_list.php';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='../category_list.php';</script>";
    }
}
?>