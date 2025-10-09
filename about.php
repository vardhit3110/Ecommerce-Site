<?php
require "db_connect.php";


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
    <style>
        body {
            background: #f5f7fb;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        .about-container {
            padding: 60px 0;
        }

        .about-text h2 {
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .about-text p {
            color: #444;
            line-height: 1.8;
        }

        .rating-box {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .rating-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .progress {
            height: 10px;
            background: #e6e6e6;
            border-radius: 5px;
            margin-top: 5px;
            overflow: hidden;
        }

        .progress-bar {
            background: linear-gradient(90deg, #4f46e5, #3b82f6);
            width: 0%;
            transition: width 1.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .rating-label {
            font-weight: 500;
            color: #222;
        }

        .owner-section {
            margin-top: 70px;
            background: #fff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .owner-section img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #4f46e5;
            transition: transform 0.4s ease;
        }

        .owner-section img:hover {
            transform: scale(1.05);
        }

        .owner-info h4 {
            font-weight: 600;
            color: #1a1a1a;
        }

        .owner-info p {
            color: #555;
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            .owner-section {
                text-align: center;
                justify-content: center;
            }

            .owner-section img {
                margin-bottom: 15px;
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <?php require "header.php"; ?>

    <div class="container about-container">
        <div class="row">
            <!-- About Text -->
            <div class="col-md-6 about-text">
                <h2>Welcome to <span style="color:#4f46e5;">MobileSite</span></h2>
                <p><b>MobileSite</b> is a leading platform for premium smartphones, accessories, and repair services.
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
                <h4>Arjun Verma</h4>
                <p><strong>Founder & CEO, MobileSite</strong></p>
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