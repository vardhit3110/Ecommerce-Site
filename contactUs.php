<?php
session_start();
error_reporting(0);
$useremail = $_SESSION['email'];
$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="assets/contactUs.css">
</head>

<body>
    <?php include "header.php"; ?>

    <div class="contact-container">
        <!-- Left Image -->
        <div class="contact-left">
            <img src="./store/images/Contact Us.jpg" alt="Contact Image">
        </div>

        <!-- Right: Contact Form -->
        <div class="contact-right">
            <h2>Contact Us</h2>

            <form method="post" action="./partials/contactUs.php">
                <div class="inputGroup">
                    <input type="text" name="username" value="<?php echo $username; ?>" required autocomplete="off">
                    <label for="name">Your Name</label>
                </div>

                <div class="inputGroup">
                    <input type="email" name="email" value="<?php echo $useremail; ?>" required autocomplete="off">
                    <label for="email">Your Email</label>
                </div>

                <div class="inputGroup">
                    <input type="text" name="subject" required autocomplete="off">
                    <label for="subject">Subject</label>
                </div>

                <div class="inputGroup">
                    <textarea name="message" required></textarea>
                    <label for="message">Your Message</label>
                </div>

                <!-- <button type="submit">Send Message</button> -->
                <center>
                    <button class="continue-application" name="send_contact" type="submit">
                        <div>
                            <div class="pencil"></div>
                            <div class="folder">
                                <div class="top">
                                    <svg viewBox="0 0 24 27">
                                        <path
                                            d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="paper"></div>
                            </div>
                        </div>
                        Send Message
                    </button>
                </center>

            </form>
        </div>

        <!-- Map Section -->
        <div class="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3494.478621876203!2d72.52253367500427!3d23.04748951539839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e85a3d6a45497%3A0xae503638b1ac5200!2sPerceptioncare%20-%20Web%20and%20Mobile%20App%20Development%20Company!5e1!3m2!1sen!2sin!4v1764764790753!5m2!1sen!2sin"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>

</html>