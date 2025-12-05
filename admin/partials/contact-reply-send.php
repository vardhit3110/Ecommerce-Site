<?php
require "db_connect.php";

if (isset($_POST['contact_id'], $_POST['user_id'], $_POST['reply_message'])) {

    $contact_id = intval($_POST['contact_id']);
    $user_id = intval($_POST['user_id']);
    date_default_timezone_set("Asia/Kolkata");
    $current_time = date("Y-m-d H:i:s");
    $reply_msg = mysqli_real_escape_string($conn, $_POST['reply_message']);

    $update = "UPDATE contactus SET reply_status = '1', reply_message = '$reply_msg', updated_at='$current_time' 
               WHERE id = $contact_id";

    if (mysqli_query($conn, $update)) {
        $url = urlencode($contact_id);
        exec("php delayed_email_sender.php $url > /dev/null 2>&1 &");

        header("Location: ../user_contact.php?reply=success&contact_id=$contact_id&user_id=$user_id");
        exit;

    } else {
        echo "DB Error: " . mysqli_error($conn);
    }
}
?>
