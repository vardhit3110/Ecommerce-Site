<?php
session_start();
require 'db_connect.php';

require 'phpmailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = "Please enter a valid email address.";
    } else {

        $stmt = $conn->prepare("SELECT id, email FROM userdata WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows === 0) {
            $errors = "This email is not registered with us.";
        } else {
            $user = $res->fetch_assoc();
            $userId = $user['id'];

            $token = bin2hex(random_bytes(16));
            $expires = date('Y-m-d H:i:s', time() + 60 * 60);

            $baseUrl = "http://localhost/core-php";
            $resetLink = $baseUrl . "/change_password.php?token=" . $token . "&email=" . urlencode($email);

            $mail = new PHPMailer(true);
            try {

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'gujjudayro21@gmail.com';
                $mail->Password = 'fumf livn uijg tiuj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('gujjudayro21@gmail.com', 'MobileSite');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "
    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6;'>
        <h2 style='color: #2c3e50;'>Hi, {$email}</h2>
        <p>We received a request to reset your password.</p>
        <p>Click the button below to set a new password. This link will be valid for <strong>1 hour</strong>.</p>
            <p style='text-align: center; margin: 30px 0;'>
                <a href='{$resetLink}'style='background-color: #314D70;
                        color: #ffffff;
                        text-decoration: none;
                        padding: 10px 22px;
                        border-radius: 6px;
                        font-size: 15px;
                        font-weight: 600;
                        font-family: Arial, Helvetica, sans-serif;
                        display: inline-block;
                        box-shadow: 0 3px 8px rgba(0,0,0,0.15);'>
                🔒 Reset Your Password
                </a>
            </p>
        <p>If you did not request this, please ignore this email.</p>
        <hr style='border: none; border-top: 1px solid #ddd; margin: 25px 0;'>
        <p style='font-size: 13px; color: #888;'>Thank you,<br>The Support Team</p>
    </div>
";
                $mail->AltBody = "Visit this link to reset your password: {$resetLink}";

                // Attempt to send
                if ($mail->send()) {

                    $update = $conn->prepare("UPDATE userdata SET is_used = '1', reset_token = ?, reset_expires = ? WHERE id = ?");
                    $update->bind_param('ssi', $token, $expires, $userId);
                    if ($update->execute()) {

                        header("Location: SendLink-Email.php");
                        exit;
                    } else {
                        $errors = "Could not update database. Please try again later.";

                    }
                } else {
                    $errors = "Failed to send email. Please try again later.";
                }
            } catch (Exception $e) {
                // PHPMailer exception
                $errors = "Mailer Error: " . $mail->ErrorInfo;
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password - Mobile Site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/ResetPassword.css">

</head>

<body>
    <?php include "header.php"; ?>
    <section class="forgot-wrapper">
        <div class="forgot-left">
            <div class="forgot-card">
                <h2>Forgot Your Password?</h2>
                <p>Enter your registered email below and we’ll send you a reset link to recover your account.</p>
                <?php if ($errors): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($errors); ?></div>
                <?php endif; ?>

                <form id="forgotForm" method="post" action="ResetPassword.php">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="example@domain.com" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-send" id="sendBtn">Send Link</button>
                    </div>
                    <a href="index.php" class="home-link d-flex justify-content-center">&larr; Back to Home</a>
                </form>
            </div>
        </div>

        <div class="forgot-right">
            <div class="overlay"></div>
            <div class="right-content">
                <h1>Welcome to Mobile Site</h1>
                <p>Your one-stop online store for mobiles, mobile accessories, earbuds, and more — shop with ease and
                    confidence.</p>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include "footer.php"; ?>
</body>

</html>