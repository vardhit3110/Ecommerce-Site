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

        /* From Uiverse.io by Nawsome */
        .continue-application {
            --color: #fff;
            --background: #404660;
            --background-hover: #3A4059;
            --background-left: #2B3044;
            --folder: #F3E9CB;
            --folder-inner: #BEB393;
            --paper: #FFFFFF;
            --paper-lines: #BBC1E1;
            --paper-behind: #E1E6F9;
            --pencil-cap: #fff;
            --pencil-top: #275EFE;
            --pencil-middle: #fff;
            --pencil-bottom: #5C86FF;
            --shadow: rgba(13, 15, 25, .2);
            border: none;
            outline: none;
            cursor: pointer;
            position: relative;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            line-height: 19px;
            -webkit-appearance: none;
            -webkit-tap-highlight-color: transparent;
            padding: 17px 29px 17px 69px;
            transition: background 0.3s;
            color: var(--color);
            background: var(--bg, var(--background));
        }

        .continue-application>div {
            top: 0;
            left: 0;
            bottom: 0;
            width: 53px;
            position: absolute;
            overflow: hidden;
            border-radius: 5px 0 0 5px;
            background: var(--background-left);
        }

        .continue-application>div .folder {
            width: 23px;
            height: 27px;
            position: absolute;
            left: 15px;
            top: 13px;
        }

        .continue-application>div .folder .top {
            left: 0;
            top: 0;
            z-index: 2;
            position: absolute;
            transform: translateX(var(--fx, 0));
            transition: transform 0.4s ease var(--fd, 0.3s);
        }

        .continue-application>div .folder .top svg {
            width: 24px;
            height: 27px;
            display: block;
            fill: var(--folder);
            transform-origin: 0 50%;
            transition: transform 0.3s ease var(--fds, 0.45s);
            transform: perspective(120px) rotateY(var(--fr, 0deg));
        }

        .continue-application>div .folder:before,
        .continue-application>div .folder:after,
        .continue-application>div .folder .paper {
            content: "";
            position: absolute;
            left: var(--l, 0);
            top: var(--t, 0);
            width: var(--w, 100%);
            height: var(--h, 100%);
            border-radius: 1px;
            background: var(--b, var(--folder-inner));
        }

        .continue-application>div .folder:before {
            box-shadow: 0 1.5px 3px var(--shadow), 0 2.5px 5px var(--shadow), 0 3.5px 7px var(--shadow);
            transform: translateX(var(--fx, 0));
            transition: transform 0.4s ease var(--fd, 0.3s);
        }

        .continue-application>div .folder:after,
        .continue-application>div .folder .paper {
            --l: 1px;
            --t: 1px;
            --w: 21px;
            --h: 25px;
            --b: var(--paper-behind);
        }

        .continue-application>div .folder:after {
            transform: translate(var(--pbx, 0), var(--pby, 0));
            transition: transform 0.4s ease var(--pbd, 0s);
        }

        .continue-application>div .folder .paper {
            z-index: 1;
            --b: var(--paper);
        }

        .continue-application>div .folder .paper:before,
        .continue-application>div .folder .paper:after {
            content: "";
            width: var(--wp, 14px);
            height: 2px;
            border-radius: 1px;
            transform: scaleY(0.5);
            left: 3px;
            top: var(--tp, 3px);
            position: absolute;
            background: var(--paper-lines);
            box-shadow: 0 12px 0 0 var(--paper-lines), 0 24px 0 0 var(--paper-lines);
        }

        .continue-application>div .folder .paper:after {
            --tp: 6px;
            --wp: 10px;
        }

        .continue-application>div .pencil {
            height: 2px;
            width: 3px;
            border-radius: 1px 1px 0 0;
            top: 8px;
            left: 105%;
            position: absolute;
            z-index: 3;
            transform-origin: 50% 19px;
            background: var(--pencil-cap);
            transform: translateX(var(--pex, 0)) rotate(35deg);
            transition: transform 0.4s ease var(--pbd, 0s);
        }

        .continue-application>div .pencil:before,
        .continue-application>div .pencil:after {
            content: "";
            position: absolute;
            display: block;
            background: var(--b, linear-gradient(var(--pencil-top) 55%, var(--pencil-middle) 55.1%, var(--pencil-middle) 60%, var(--pencil-bottom) 60.1%));
            width: var(--w, 5px);
            height: var(--h, 20px);
            border-radius: var(--br, 2px 2px 0 0);
            top: var(--t, 2px);
            left: var(--l, -1px);
        }

        .continue-application>div .pencil:before {
            -webkit-clip-path: polygon(0 5%, 5px 5%, 5px 17px, 50% 20px, 0 17px);
            clip-path: polygon(0 5%, 5px 5%, 5px 17px, 50% 20px, 0 17px);
        }

        .continue-application>div .pencil:after {
            --b: none;
            --w: 3px;
            --h: 6px;
            --br: 0 2px 1px 0;
            --t: 3px;
            --l: 3px;
            border-top: 1px solid var(--pencil-top);
            border-right: 1px solid var(--pencil-top);
        }

        .continue-application:before,
        .continue-application:after {
            content: "";
            position: absolute;
            width: 10px;
            height: 2px;
            border-radius: 1px;
            background: var(--color);
            transform-origin: 9px 1px;
            transform: translateX(var(--cx, 0)) scale(0.5) rotate(var(--r, -45deg));
            top: 26px;
            right: 16px;
            transition: transform 0.3s;
        }

        .continue-application:after {
            --r: 45deg;
        }

        .continue-application:hover {
            --cx: 2px;
            --bg: var(--background-hover);
            --fx: -40px;
            --fr: -60deg;
            --fd: .15s;
            --fds: 0s;
            --pbx: 3px;
            --pby: -3px;
            --pbd: .15s;
            --pex: -24px;
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

                <!-- From Uiverse.io by Nawsome -->
                <center>
                    <button class="continue-application">
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