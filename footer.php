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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
                    <li><i class="fas fa-map-marker-alt"></i> 123 Mobile Street, City</li>
                    <li><i class="fas fa-phone"></i> +1 234 567 8900</li>
                    <li><i class="fas fa-envelope"></i> info@mobilesite.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2023 MobileSite. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>