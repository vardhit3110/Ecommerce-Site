<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Email Sent - Mobile Site</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="assets/SendLink-Email.css">
</head>

<body>
    <?php include "header.php"; ?>

    <section class="forgot-wrapper">
        <!-- Left Side -->
        <div class="forgot-left">
            <div class="forgot-card">
                <div class="emoji">😊</div>
                <h2>Check Your Email!</h2>
                <p>We’ve sent a password reset link to your registered email address.<br>
                    Please open your inbox and click the link to reset your password.</p>
                <p><strong>Thank you!</strong> We’re here to help you get back in quickly.</p>

                <div class="d-grid">
                    <a href="index.php" class="btn btn-primary btn-back">Go to Home</a>
                </div>
            </div>
        </div>

        <!-- right side -->
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
