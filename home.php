<?php
require_once "header.php";
$sql = "SELECT * FROM sitedetail";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $systemName = $row['systemName'];
    $email = $row['email'];
    $contact = $row['contact'];
    $address = $row['address'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileSite</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/home.css">
</head>

<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="overlay"></div>
        <div class="hero-content"><br><br><br>
            <img src="./store/images/logo.jpg" alt="Logo">
            <h1>Welcome to <?php echo $systemName; ?></h1>
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