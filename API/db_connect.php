<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "core";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Error" . mysqli_connect_error());
}
?>