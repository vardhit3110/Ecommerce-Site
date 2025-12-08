<?php
require "db_connect.php";
require "../PHPMailer/PHPMailer.php";
require "../PHPMailer/SMTP.php";
require "../PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['contact_id'], $_POST['user_id'], $_POST['reply_message'], $_POST['user_email'])) {

    $contact_id = intval($_POST['contact_id']);
    $user_id = intval($_POST['user_id']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $reply_msg = mysqli_real_escape_string($conn, $_POST['reply_message']);

    date_default_timezone_set("Asia/Kolkata");
    $current_time = date("Y-m-d H:i:s");


    $update = "UPDATE contactus SET reply_status = '1', reply_message = '$reply_msg', updated_at='$current_time' WHERE id = $contact_id";
    if (mysqli_query($conn, $update)) {

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;

            //  Your email login credentials
            $mail->Username = "gujjudayro21@gmail.com"; 
            $mail->Password = "fumf livn uijg tiuj";     

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender & Receiver
            $mail->setFrom("gujjudayro21@gmail.com", "Admin Support");
            $mail->addAddress($user_email);

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = "Reply to your Contact Message";
            $mail->Body = "
                <h3>Hello User,</h3>
                <p>We have replied to your query:</p>
                <p><strong>Your Message Reply:</strong></p>
                <p>$reply_msg</p>
                <br>
                <p>Thank you!</p>
            ";

            $mail->send();

            // Redirect After Success
            header("Location: ../user_contact.php?reply=success&contact_id=$contact_id&user_id=$user_id");
            exit;

        } catch (Exception $e) {
            echo "Email Error: " . $mail->ErrorInfo;
        }

    } else {
        echo "DB Error: " . mysqli_error($conn);
    }
}
?>
