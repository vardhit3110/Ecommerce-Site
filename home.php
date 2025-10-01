<?php require_once "header.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileSite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            scroll-behavior: smooth;
            line-height: 1.6;
            color: #333;
        }

        .hero {
            background-image: url('./store/images/Mobile%20Accessories_backgraound.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            position: relative;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.4) 100%);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 0 20px;
            max-width: 800px;
        }

        .hero-content img {
            width: 120px;
            margin-bottom: 20px;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
        }

        .hero-content h1 {
            font-size: 32px;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .hero-content h2 {
            font-size: 42px;
            margin: 15px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            font-weight: 700;
        }

        .hero-content p {
            font-size: 18px;
            margin: 20px 0;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .hero-content button {
            margin-top: 30px;
            padding: 15px 35px;
            font-size: 18px;
            background-color: #ffffff;
            border: none;
            color: #000;
            cursor: pointer;
            border-radius: 30px;
            transition: all 0.3s;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-content button:hover {
            background-color: #007bff;
            color: white;
            transform: translateY(-3px);
        }


        .product-container {
            padding: 80px 20px;
            background-color: #f9f9f9;
            text-align: center;
        }

        .product-container h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
            position: relative;
            display: inline-block;
        }

        .product-container h2:after {
            content: '';
            position: absolute;
            width: 60%;
            height: 3px;
            background: #007bff;
            bottom: -10px;
            left: 20%;
        }

        .product-intro {
            max-width: 800px;
            margin: 0 auto 40px;
            font-size: 18px;
            color: #555;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
        }

        .product-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px 20px;
            width: 280px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .product-icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 20px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card h3 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #333;
        }

        .product-card p {
            font-size: 15px;
            color: #666;
            margin-bottom: 20px;
            min-height: 100px;
        }

        .product-features {
            text-align: left;
            margin: 20px 0;
            font-size: 14px;
        }

        .product-features li {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .product-features i {
            color: #007bff;
            margin-right: 8px;
            font-size: 12px;
        }

        .product-card button {
            margin-top: 15px;
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background 0.3s;
            width: 100%;
        }

        .product-card button:hover {
            background-color: #0056b3;
        }

        .draft-container {
            padding: 60px 20px;
            background-color: #ececec;
            text-align: center;
        }

        .draft-container h3 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .draft-container p {
            max-width: 800px;
            margin: auto;
            font-size: 18px;
            color: #555;
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 26px;
            }

            .hero-content h2 {
                font-size: 32px;
            }

            .product-container {
                padding: 50px 15px;
            }

            .product-card {
                width: 100%;
                max-width: 350px;
            }
        }
        .gotoweb{
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            color: #0056b3;
        }
        .gotoweb:hover{
            color: red;
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content"><br><br><br>
            <img src="./store/images/logo.jpg" alt="Logo">
            <h1>Welcome to MobileSite</h1>
            <h2>Explore the Future of Mobility</h2>
            <button onclick="document.getElementById('products').scrollIntoView({behavior: 'smooth'})">Explore
                Products</button><br><br><br><br>
        </div>
    </section>

    <!-- Product Section -->
    <section class="product-container" id="products">
        <h2>Our Premium Products</h2>
        <p class="product-intro">We offer a wide range of high-quality mobile accessories designed to enhance your
            device's performance and your overall user experience. Each product is carefully selected and tested to meet
            our high standards.</p>

        <div class="product-list">
            <div class="product-card">
                <div class="product-icon">
                    <i class="fas fa-microchip"></i>
                </div>
                <h3>Fast Processor</h3>
                <p>Experience lightning-fast performance with our advanced mobile processors. Perfect for gaming,
                    multitasking, and running demanding applications.</p>
                <ul class="product-features">
                    <li><i class="fas fa-check"></i> Up to 3.2GHz clock speed</li>
                    <li><i class="fas fa-check"></i> 8-core architecture</li>
                    <li><i class="fas fa-check"></i> Advanced cooling technology</li>
                    <li><i class="fas fa-check"></i> Energy efficient design</li>
                </ul>
                <!-- <button onclick="location.href='processors.html'">View Details</button> -->
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <i class="fas fa-battery-full"></i>
                </div>
                <h3>High Capacity Battery</h3>
                <p>Never run out of power with our long-lasting mobile batteries. Designed for extended use and fast
                    charging capabilities.</p>
                <ul class="product-features">
                    <li><i class="fas fa-check"></i> 5000mAh capacity</li>
                    <li><i class="fas fa-check"></i> Fast charging technology</li>
                    <li><i class="fas fa-check"></i> Overcharge protection</li>
                    <li><i class="fas fa-check"></i> Extended lifespan</li>
                </ul>
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Crystal Clear Display</h3>
                <p>Enjoy stunning visuals with our high-resolution displays. Perfect for media consumption, gaming, and
                    professional work.</p>
                <ul class="product-features">
                    <li><i class="fas fa-check"></i> 4K resolution</li>
                    <li><i class="fas fa-check"></i> HDR10+ support</li>
                    <li><i class="fas fa-check"></i> 120Hz refresh rate</li>
                    <li><i class="fas fa-check"></i> Eye comfort technology</li>
                </ul>
                <!-- <button onclick="location.href='displays.html'">View Details</button> -->
            </div>

            <div class="product-card">
                <div class="product-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h3>Advanced Camera</h3>
                <p>Capture life's moments with exceptional clarity using our advanced camera modules. Professional-grade
                    photography in your pocket.</p>
                <ul class="product-features">
                    <li><i class="fas fa-check"></i> 108MP main sensor</li>
                    <li><i class="fas fa-check"></i> Optical image stabilization</li>
                    <li><i class="fas fa-check"></i> 8K video recording</li>
                    <li><i class="fas fa-check"></i> AI-enhanced photography</li>
                </ul>
                <!-- <button onclick="location.href='cameras.html'">View Details</button> -->
            </div>
        </div>
    </section>

    <!-- Draft Section -->
    <section class="draft-container" id="about">
        <h3>Innovation at Our Core</h3>
        <p>At MobileSite, we're passionate about pushing the boundaries of mobile technology. Our team of engineers and
            designers work tirelessly to develop accessories that not only meet but exceed your expectations. We believe
            in creating products that seamlessly integrate into your life, enhancing your mobile experience without
            compromise.</p>
        <p>Stay connected with us for the latest product releases, technological advancements, and exclusive offers in
            the mobile world. Join our community of tech enthusiasts and be the first to experience the future of
            mobility. <a href="index.php" class="gotoweb">Go Website →</a></p>
    </section>

    <!-- Footer -->
    <?php require_once "footer.php"; ?>

</body>

</html>