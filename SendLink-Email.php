<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Email Sent - Mobile Site</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .forgot-wrapper {
            min-height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        .forgot-left {
            flex: 1 1 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            background-color: #f9fafc;
        }

        .forgot-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .emoji {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: bounce 1.4s infinite ease-in-out;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .forgot-card h2 {
            font-weight: 600;
            color: #0b4660;
            margin-bottom: .75rem;
        }

        .forgot-card p {
            color: #6b6f73;
            font-size: 0.97rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .btn-back {
            height: 46px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #08384f;
        }

        .home-link {
            display: inline-block;
            margin-top: 1rem;
            color: #0b4660;
            font-weight: 600;
            text-decoration: none;
        }

        .home-link:hover {
            text-decoration: underline;
        }

        .forgot-right {
            flex: 1 1 50%;
            background: url('./store/images/password_resetBG.jpeg') center/cover no-repeat;
            position: relative;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .right-content {
            position: relative;
            z-index: 2;
            padding: 2rem;
        }

        .right-content h1 {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .right-content p {
            font-size: 1rem;
            margin-top: 0.75rem;
            opacity: 0.9;
        }

        @media (max-width: 991px) {

            .forgot-left,
            .forgot-right {
                flex: 1 1 100%;
            }

            .forgot-right {
                min-height: 230px;
            }

            .right-content h1 {
                font-size: 1.6rem;
            }
        }
    </style>
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
