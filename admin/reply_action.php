<?php
require "db_connect.php";
require "PHPMailer/PHPMailer.php";
require "PHPMailer/SMTP.php";
require "PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
if (isset($_POST['contact_id'], $_POST['user_id'], $_POST['reply_message'], $_POST['user_email'])) {
    $contact_id = intval($_POST['contact_id']);
    $user_id = intval($_POST['user_id']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $reply_msg = mysqli_real_escape_string($conn, $_POST['reply_message']);

    $contact = mysqli_fetch_assoc(mysqli_query($conn, "SELECT c.subject, c.message, u.username FROM contactus c JOIN userdata u ON c.user_id = u.id WHERE c.id = $contact_id"));
    $user_name = $contact['username'];
    $subject = $contact['subject'];
    $user_message = $contact['message'];
    date_default_timezone_set("Asia/Kolkata");
    $current_time = date("Y-m-d H:i:s");

    $update = "UPDATE contactus SET reply_status = '1', reply_message = '$reply_msg', updated_at='$current_time' WHERE id = $contact_id";
    if (mysqli_query($conn, $update)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "gujjudayro21@gmail.com";
            $mail->Password = "fumf livn uijg tiuj";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->setFrom("gujjudayro21@gmail.com", "MobileSite");
            $mail->addAddress($user_email);
            $mail->isHTML(true);
            $mail->Subject = "Reply to your Contact Message";
            $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width:650px; margin:auto; padding:20px; border:1px solid #ddd; border-radius:8px;'>
                <h3 style='text-align:center; margin-bottom:25px;'>Contact Us – Reply</h3>
                <table style='width:100%; border-collapse:collapse;'>
                    <tr>
                        <td style='padding:10px; border:1px solid #ccc; width:35%; font-weight:bold;'>User Name</td>
                        <td style='padding:10px; border:1px solid #ccc; font-weight:bold;'>Subject</td>
                        <td style='padding:10px; border:1px solid #ccc; font-weight:bold;'>Your Message</td>
                        <td style='padding:10px; border:1px solid #ccc; font-weight:bold;'>Admin Reply</td>
                    </tr>
                    <tr>
                        <td style='padding:10px; border:1px solid #ccc;'>{$user_name}</td>
                        <td style='padding:10px; border:1px solid #ccc;'>{$subject}</td>
                        <td style='padding:10px; border:1px solid #ccc;'>{$user_message}</td>
                        <td style='padding:10px; border:1px solid #ccc;'>{$reply_msg}</td>
                    </tr>
                </table>
                <p style='margin-top:25px;'>Thank you for contacting us!</p>
            </div>";
            $mail->send();
            mysqli_query($conn, "UPDATE contactus SET email_send = '1' WHERE id = $contact_id");
            echo json_encode(['status' => 'success', 'message' => 'Reply sent successfully!']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => "Database Error: " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request!']);
}
?>