<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "vardhit";

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Error" . mysqli_connect_error());
}
?>