<?php
include "db_connect.php";

$sql = "SELECT * FROM sitedetail";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $systemName = $row['systemName'];
    $adminemail = $row['email'];
    $admincontact = $row['contact'];
    $adminaddress = $row['address'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <?php require "links/icons.html"; ?>
    <link rel="stylesheet" href="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: 3px;
        }

        .input-wrapper {
            display: flex;
            flex-direction: column;
        }


        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 30px 20px 20px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .footer-section {
            flex: 1;
        }

        .footer-section h3 {
            margin-bottom: 15px;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 8px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 2px;
            background-color: #3498db;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #3498db;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-links a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background-color: #34495e;
            border-radius: 50%;
            color: white;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background-color: #3498db;
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid #34495e;
            font-size: 0.9rem;
            color: #95a5a6;
        }

        .subscribe-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .subscribe-form input[type="email"] {
            padding: 10px;
            border: none;
            border-radius: 4px;
            outline: none;
            font-size: 1rem;
            width: 100%;
        }

        .subscribe-form button {
            padding: 10px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .subscribe-form button:hover {
            background-color: #2980b9;
        }

        @media (min-width: 768px) {
            .subscribe-form {
                flex-direction: row;
            }

            .subscribe-form input[type="email"] {
                flex: 1;
            }

            .subscribe-form button {
                width: auto;
                margin-left: 10px;
            }
        }


        @media (min-width: 768px) {
            .footer-container {
                flex-direction: row;
            }

            .auth-btn {
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            .logo span {
                display: none;
            }

            .logo i {
                margin-right: 0;
                font-size: 2rem;
            }

            .auth-btn {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }

        .subscribe-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .subscribe-form {
                flex-direction: row;
                align-items: flex-start;
                /* Prevents stretching */
            }

            .input-wrapper {
                flex: 1;
            }

            .button-wrapper {
                margin-left: 10px;
            }
        }

        .input-wrapper {
            display: flex;
            flex-direction: column;
        }

        .input-wrapper input[type="email"] {
            padding: 10px;
            border: none;
            border-radius: 4px;
            outline: none;
            font-size: 1rem;
            width: 100%;
        }

        .subscribe-form button {
            padding: 10px;
            border: none;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
            white-space: nowrap;
        }

        .subscribe-form button:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <footer class="footer-v">
        <div class="footer-container">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We are a mobile-first company dedicated to creating amazing experiences for mobile users.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i><?php echo $adminaddress; ?></li>
                    <li><i class="fas fa-phone"></i> <?php echo $admincontact; ?></li>
                    <li><i class="fas fa-envelope"></i> <?php echo $adminemail; ?></li>
                </ul>
            </div>

            <!--  Subscribe Section -->
            <div class="footer-section">
                <h3>Subscribe</h3>
                <p>Stay updated with our latest news and offers.</p>
                <form class="subscribe-form" method="post" id="myForm">
                    <div class="input-wrapper">
                        <input type="email" placeholder="Enter your email" name="subscriber_email" required>
                    </div>
                    <div class="button-wrapper">
                        <button type="submit" name="sub">subscriber</button>
                    </div>
                </form>
                <script>
                    $(document).ready(function () {
                        $("#myForm").validate({
                            rules: {
                                emailField: {
                                    required: true,
                                    email: true
                                }
                            },
                            messages: {
                                emailField: {
                                    required: "Please enter your email address.",
                                    email: "Please enter a valid email address."
                                }
                            },
                            errorPlacement: function (error, element) {
                                error.insertAfter(element);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <?php

        if (isset($_POST['sub'])) {
            $subscriber_email = trim($_POST['subscriber_email']);

            $check_email = "SELECT * FROM subscriber WHERE subscriber_email = ?";
            $stmt = mysqli_prepare($conn, $check_email);
            mysqli_stmt_bind_param($stmt, "s", $subscriber_email);
            mysqli_stmt_execute($stmt);
            $result_subscriber = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result_subscriber) > 0) {
                echo "<script>alert('Already Subscribed.');</script>";
                exit();
            } else {

                $sub_query = "INSERT INTO subscriber (subscriber_email) VALUES (?)";
                $stmt = mysqli_prepare($conn, $sub_query);
                mysqli_stmt_bind_param($stmt, "s", $subscriber_email);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    echo "<script>alert('Subscriber Successful!');</script>";
                } else {
                    echo "<script>alert('Subscriber Failed. Please try again later.');</script>";
                }
            }
        }
        ?>

        <div class="footer-bottom">
            <p>&copy; 2025 MobileSite. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>