<?php
require "slider.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['catId']) && isset($_POST['status'])) {
        $catId = intval($_POST['catId']);
        $status = intval($_POST['status']);
        
        // Update the category status
        $stmt = mysqli_prepare($conn, "UPDATE categories SET categorie_status = ? WHERE categorie_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ii", $status, $catId);
            mysqli_stmt_execute($stmt);
            
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "success";
            } else {
                echo "error";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>