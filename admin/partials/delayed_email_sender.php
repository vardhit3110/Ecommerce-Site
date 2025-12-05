<?php
sleep(60);

require "db_connect.php";
require "../PHPMailer/PHPMailer.php";
require "../PHPMailer/SMTP.php";
require "../PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$contact_id = intval($argv[1]);

$sql = "SELECT c.reply_message, c.email FROM contactus c WHERE c.id = $contact_id LIMIT 1";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);

$reply_msg = $data['reply_message'];
$email = $data['email'];

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "gujjudayro21@gmail.com";
    $mail->Password = "fumf livn uijg tiuj";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom("gujjudayro21@gmail.com", "Admin Support");
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = "Your Reply From Support Team";
    $mail->Body = nl2br($reply_msg);

    $mail->send();

} catch (Exception $e) {

}

?>