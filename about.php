<?php
require "db_connect.php";

$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $phone = $row['phone'];
    $bio = $row['bio'];
}
$sql = "SELECT * FROM sitedetail ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
   $systemName=$row['systemName'];
}

$totalQuery = "SELECT COUNT(*) AS total FROM feedback";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$total = $totalRow['total'];

$ratingData = [];
for ($i = 5; $i >= 1; $i--) {
    $query = "SELECT COUNT(*) AS count FROM feedback WHERE rating = $i";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $ratingData[$i] = $total > 0 ? round(($row['count'] / $total) * 100) : 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - MobileSite</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/about.css">
</head>

<body>

    <?php require "header.php"; ?>

    <div class="container about-container">
        <div class="row">
            <!-- About Text -->
            <div class="col-md-6 about-text">
                <h2>Welcome to <span style="color:#4f46e5;"><?php echo $systemName ;?></span></h2>
                <p><b><?php echo $systemName ;?></b> is a leading platform for premium smartphones, accessories, and repair services.
                    We’re passionate about providing users with high-quality devices and top-notch support that redefine
                    the mobile shopping experience.</p>

                <p>Since our inception in 2021, our mission has been simple — to make the latest technology
                    accessible, reliable, and affordable for everyone. From flagship phones to daily-use gadgets,
                    MobileSite ensures trust, transparency, and tech excellence.</p>
            </div>

            <!-- Rating Display -->
            <div class="col-md-6">
                <div class="rating-box">
                    <h4 class="mb-4 text-center">Customer Ratings</h4>
                    <?php
                    for ($i = 5; $i >= 1; $i--) {
                        echo '
              <div class="mb-3">
                <div class="d-flex justify-content-between">
                  <span class="rating-label">' . $i . ' Star</span>
                  <span>' . $ratingData[$i] . '%</span>
                </div>
                <div class="progress">
                  <div class="progress-bar" data-width="' . $ratingData[$i] . '%"></div>
                </div>
              </div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Owner Section -->
        <div class="owner-section mt-5">
            <img src="./store/images/owner.jpeg" alt="Owner">
            <div class="owner-info">
                <h4><?php echo $lname . " " . $fname; ?></h4>
                <p><strong>Founder & CEO, <?php echo $systemName; ?></strong></p>
                <p>“We’re not just selling phones — we’re delivering innovation in your hands.”</p>
                <p>Under Arjun’s leadership, MobileSite has become a trusted name in mobile e-commerce, offering the
                    best prices, authentic products, and a seamless digital experience to customers across India.</p>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script>
        // Smooth rating animation
        document.addEventListener("DOMContentLoaded", () => {
            const bars = document.querySelectorAll('.progress-bar');
            bars.forEach(bar => {
                const width = bar.getAttribute('data-width');
                setTimeout(() => {
                    bar.style.width = width;
                }, 400);
            });
        });
    </script>

</body>

</html>