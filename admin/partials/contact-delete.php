<?php
require "../db_connect.php";

if (isset($_GET['id'])) {
    $contact_id = intval($_GET['id']);

    $delete = "DELETE FROM contactus WHERE id = $contact_id";
    if (mysqli_query($conn, $delete)) {
        header("Location: ../user_contact.php?delete=success");
        exit;
    } else {
        echo "Error deleting message: " . mysqli_error($conn);
    }
} else {
    header("Location: ../user_contact.php");
    exit;
}
?>