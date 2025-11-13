<?php
require "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $sub_title = trim($_POST['sub_title']);
    $status = 1;

    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['image_path']['tmp_name'];
        $fileName = basename($_FILES['image_path']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array($fileExt, $allowed)) {
            echo "<script>alert('Only JPG, JPEG, PNG, or WEBP files are allowed.'); window.history.back();</script>";
            exit();
        }

        $newFileName = preg_replace("/[^a-zA-Z0-9]/", "_", pathinfo($fileName, PATHINFO_FILENAME)) . "_" . time() . "." . $fileExt;
        $uploadDir = "../images/banner/";
        $uploadPath = $uploadDir . $newFileName;

        // Move file
        if (!move_uploaded_file($fileTmp, $uploadPath)) {
            echo "<script>alert('Image upload failed. Please try again.'); window.history.back();</script>";
            exit();
        }

        // Insert data into DB
        $stmt = $conn->prepare("INSERT INTO site_image (title, sub_title, image_path, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $sub_title, $newFileName, $status);

        if ($stmt->execute()) {
            echo "<script>alert('Banner added successfully!'); window.location.href='../banner.php';</script>";
        } else {
            echo "<script>alert('Database error: Unable to insert data.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please select a valid image file.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>