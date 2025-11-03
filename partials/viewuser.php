<?php
include "db_connect.php";

if (isset($_GET['email']) && !empty($_GET['email'])) {
    $get_email = $_GET['email'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM userdata WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $get_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
        $phone = $row['phone'];
        $address = $row['address'];
        $city = $row['city'];
        $image = $row['image'];
        $gender = $row['gender'];
    } else {
        echo "<script>alert('User not found.');</script>";
        exit;
    }
    mysqli_stmt_close($stmt);
}
?>
