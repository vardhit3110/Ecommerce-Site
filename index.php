<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MobileSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        #card-color {
            color: #0023c0ff;
            font-weight: 600;
        }

        #main-container {
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        #main-container:hover {
            transform: scale(1.03);
            /* box-shadow: 0 6px 18px rgba(0, 119, 204, 0.3); */
        }

        .not-data {
            background-color: #ffebebff;
            border-radius: 8px;
        }

        .detail-box:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0, 119, 204, 0.3);
            background: linear-gradient(135deg, #e0f7ff, #cceeff);
        }

        .carousel-inner img {
            height: 360px;
            object-fit: fill;
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .carousel-inner img {
                height: 280px;
            }
        }

        .top-deals-container {
            width: 100%;
            background-color: #ffffffff;
            padding: 40px 50px;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .top-deals-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 20px;
        }

        /* Product Card */
        .product-card {
            border: none;
            text-align: center;
            background: white;
            border-radius: 10px;
            transition: transform 0.3s ease;
            cursor: pointer;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            width: 200px;
            flex: 0 0 auto;
        }

        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: contain;
            transition: transform 0.3s ease;
            padding: 10px;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 10px 5px;
        }

        .product-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #222;
        }

        .product-price {
            font-size: 0.9rem;
            color: #000000ff;
            font-weight: 700;
        }

        .order-count {
            font-size: 0.85rem;
            color: #28a745;
        }

        .carousel-inner {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
        }

        .carousel-inner::-webkit-scrollbar {
            display: none;
        }

        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: #333;
            border: none;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            z-index: 5;
        }

        .carousel-btn:hover {
            background-color: #007bff;
        }

        .carousel-btn.prev {
            left: 10px;
        }

        .carousel-btn.next {
            right: 10px;
        }

        @media (max-width: 1200px) {
            .product-card {
                width: 180px;
            }
        }

        @media (max-width: 992px) {
            .product-card {
                width: 160px;
            }
        }

        @media (max-width: 768px) {
            .product-card {
                width: 140px;
            }

            .top-deals-title {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .product-card {
                width: 120px;
            }
        }
    </style>
</head>

<body>

    <?php require_once "header.php"; ?>
    <?php
    include "db_connect.php";

    /* showbanner */
    $query = "SELECT * FROM site_image WHERE status = 1 ORDER BY id DESC";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo '<div id="mainCarousel" class="carousel slide mt-2 container" data-bs-ride="carousel">
                <div class="carousel-inner rounded-3 shadow">';

            $active = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $title = htmlspecialchars($row['title']);
                $sub_title = htmlspecialchars($row['sub_title']);
                $image_path = htmlspecialchars($row['image_path']);

                echo '
                <div class="carousel-item ' . ($active ? 'active' : '') . '">
                    <img src="./admin/images/banner/' . $image_path . '" class="d-block w-100" alt="' . $title . '">
                    <div class="carousel-caption d-none d-md-block"></div>
                </div>';
                $active = false;
            }

            echo '</div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>';
        }

        mysqli_stmt_close($stmt);
    }
    ?>

    <!-- showCategories -->
    <main class="container py-4">
        <div class="col-lg-3 text-center my-5 mt-1 py-2 detail-box" style="margin: auto; background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
            border-top: 3px solid #0077cc; border-bottom: 3px solid #0077cc;
            border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <h2 style="color: #0077cc; font-weight: 600; letter-spacing: 1px; font-family: 'Segoe UI', sans-serif;">
                Featured Products</h2>
        </div>

        <?php
        include "db_connect.php";

        $showCategories = "SELECT * FROM categories WHERE categorie_status=?";
        $stmt = mysqli_prepare($conn, $showCategories);

        if ($stmt) {
            $categorie_status = 1;
            mysqli_stmt_bind_param($stmt, "i", $categorie_status);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {


                echo '
        <div id="catSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
        ';

                $i = 0;
                $items = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $items[] = $row;
                }

                $chunks = array_chunk($items, 4);

                foreach ($chunks as $index => $chunk) {
                    echo '<div class="carousel-item ' . ($index == 0 ? 'active' : '') . '">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">';

                    foreach ($chunk as $row) {
                        $catid = $row['categorie_id'];
                        $catImage = $row['categorie_image'];
                        $catname = $row['categorie_name'];
                        $catdesc = $row['categorie_desc'];

                        echo '<div class="col">
                        <div class="card h-100" id="main-container" onclick="window.location.href=\'viewproductList.php?id=' . $catid . '\'">
                            <div class="p-2">
                                <img src="./admin/images/' . htmlspecialchars($catImage) . '" class="card-img-top" alt="' . htmlspecialchars($catname) . '" style="height: 250px; object-fit: contain; border-radius: 5px;">
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title" id="card-color">' . htmlspecialchars($catname) . '</h5>
                                <p class="card-text" style="font-size: 0.9rem;">' . htmlspecialchars($catdesc) . '</p>
                            </div>
                        </div>
                    </div>';
                    }

                    echo '</div></div>';
                }

                // Slider Controls
                echo '
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#catSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#catSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

        </div><br><br>';
            } else {
                echo '<div class="not-data text-center">
            <div class="container">
                <p class="display-5" style="font-weight: 500;">Sorry, no Category available.</p><br>
                <p class="lead"> We will update soon.</p>
            </div>
        </div><br><br>';
            }
            mysqli_stmt_close($stmt);
        }
        ?>


        <!-- Dynamic Top Deals Section -->
        <div class="container-fluid top-deals-container">
            <div class="d-flex justify-content-between align-items-centermb-2">
                <div class="top-deals-title text-dark" style="font-weight: 700; margin-left: 20px;">Top Deals</div>
                <div>
                    <button class="carousel-btn prev" id="prevBtn">&#10094;</button>
                    <button class="carousel-btn next" id="nextBtn">&#10095;</button>
                </div>
            </div>

            <div class="carousel slide" id="topDealsCarousel">
                <div class="carousel-inner gap-5" id="carouselItems">
                    <?php
                    $sql = "SELECT product_details FROM orders WHERE order_status = '4'";
                    $result = mysqli_query($conn, $sql);
                    $productCounts = [];

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $products = json_decode($row['product_details'], true);
                            if (is_array($products)) {
                                foreach ($products as $p) {
                                    $name = trim($p['product_name']);
                                    $qty = intval($p['quantity']);
                                    if (!isset($productCounts[$name])) {
                                        $productCounts[$name] = 0;
                                    }
                                    $productCounts[$name] += $qty;
                                }
                            }
                        }
                    }

                    arsort($productCounts);
                    $topProducts = array_slice($productCounts, 0, 10, true);
                    $productData = [];

                    foreach ($topProducts as $productName => $count) {
                        $query = "SELECT p.product_Id, p.product_name, p.product_image, p.categorie_id, p.product_price, c.categorie_name FROM product p JOIN categories c ON p.categorie_id = c.categorie_id WHERE p.product_name = '" . mysqli_real_escape_string($conn, $productName) . "' LIMIT 1";
                        $res = mysqli_query($conn, $query);
                        if ($res && mysqli_num_rows($res) > 0) {
                            $data = mysqli_fetch_assoc($res);
                            $data['count'] = $count;
                            $productData[] = $data;
                        }
                    }

                    if (!empty($productData)) {
                        foreach ($productData as $p) {
                            $pPrice = $p['product_price'];
                            echo '<div class="product-card">
                                    <a href="viewproductList.php?id=' . htmlspecialchars($p['categorie_id']) . '" class="text-decoration-none">
                                        <img src="./admin/images/product_img/' . htmlspecialchars($p['product_image']) . '" alt="' . htmlspecialchars($p['product_name']) . '">
                                        <div class="product-info">
                                            <div class="product-name">' . htmlspecialchars($p['product_name']) . '</div>
                                            <div class="product-price">₹' . htmlspecialchars(number_format($pPrice, 0)) . '</div>
                                            <div class="order-count">Ordered ' . intval($p['count']) . ' times</div>
                                        </div>
                                    </a>
                                </div>';
                        }
                    } else {
                        echo '<p class="text-center text-muted">No Deal Orders Found.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        const carousel = document.getElementById('carouselItems');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: 300, behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -300, behavior: 'smooth' });
        });
    </script>

    <?php require_once "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>