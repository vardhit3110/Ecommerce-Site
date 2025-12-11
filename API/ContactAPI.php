<?php
include "db_connect.php";

header("content-type:application/json");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo json_encode([
        "status" => "Error",
        "message" => "Invalid request method"
    ]);
    exit();
}

$query = "SELECT * FROM contactus";
$result = mysqli_query($conn, $query);
$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    if ($result) {
        echo json_encode([
            "status" => "true",
            "data" => $data
        ]);
    } else {
        echo json_encode([
            "status" => "false",
            "message" => "No record found"
        ]);
    }
}
?>