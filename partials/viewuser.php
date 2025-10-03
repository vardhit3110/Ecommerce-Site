<?php
include "db_connect.php";


$stmt = mysqli_prepare($conn, "SELECT * FROM userdata WHERE email= ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
    $city = $row['city'];
    $image = $row['image'];


}
?>