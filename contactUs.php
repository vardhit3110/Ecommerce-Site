<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        .contact-container {
            max-width: 1200px;
            margin: 50px auto;
            display: flex;
            flex-wrap: wrap;
        }

        .contact-left {
            flex: 1;
            min-width: 300px;
            position: relative;
            border-radius: 10px 0 0 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            opacity: 0.7;
        }

        .contact-right {
            flex: 1;
            min-width: 300px;
            background: #fff;
            padding: 40px;
            border-radius: 0 10px 10px 0;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .contact-right h2 {
            margin-bottom: 25px;
            color: #333;
            text-align: center;
        }

        .contact-right button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            border: none;
            background: #0d6efd;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .contact-right button:hover {
            background: #004bca;
        }

        .map {
            margin: 50px auto;
            width: 100%;
            max-width: 1200px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        iframe {
            width: 100%;
            height: 350px;
            border: none;
        }

        @media (max-width: 900px) {
            .contact-container {
                flex-direction: column;
            }

            .contact-left,
            .contact-right {
                border-radius: 10px;
            }

            .contact-left .overlay h2 {
                font-size: 2rem;
            }
        }

        .inputGroup {
            font-family: 'Segoe UI', sans-serif;
            margin: 1em 0;
            max-width: 100%;
            position: relative;
        }

        .inputGroup input,
        .inputGroup textarea {
            font-size: 100%;
            padding: 0.8em;
            outline: none;
            border: 2px solid rgb(200, 200, 200);
            background-color: transparent;
            border-radius: 20px;
            width: 100%;
            resize: none;
        }

        .inputGroup label {
            font-size: 100%;
            position: absolute;
            left: 0;
            padding: 0.8em;
            margin-left: 0.5em;
            pointer-events: none;
            transition: all 0.3s ease;
            color: rgb(100, 100, 100);
        }

        .inputGroup :is(input:focus, input:valid, textarea:focus, textarea:valid)~label {
            transform: translateY(-50%) scale(.9);
            margin: 0;
            margin-left: 1.3em;
            padding: 0.4em;
            background-color: #fff;
        }

        .inputGroup :is(input:focus, input:valid, textarea:focus, textarea:valid) {
            border-color: rgb(150, 150, 200);
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>

    <div class="contact-container">
        <!-- Left Image -->
        <div class="contact-left">
            <img src="./store/images/ContactUs.jpg" alt="Contact Image">
        </div>

        <!-- Right: Contact Form -->
        <div class="contact-right">
            <h2>Send Us a Message</h2>

            <form>
                <div class="inputGroup">
                    <input type="text" name="name" required autocomplete="off">
                    <label for="name">Your Name</label>
                </div>

                <div class="inputGroup">
                    <input type="email" name="email" required autocomplete="off">
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

                <button type="submit">Send Message</button>
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