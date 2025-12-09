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
   <link rel="stylesheet" href="assets/footer.css">
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