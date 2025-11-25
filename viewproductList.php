<?php
include "db_connect.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MobileSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        ul.pagination {
            list-style: none;
            display: flex;
            gap: 10px;
            padding: 0;
            margin: 0;
        }

        ul.pagination li a {
            text-decoration: none;
            color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1px solid transparent;
            font-size: 16px;
            transition: background 0.3s, color 0.3s;
        }

        ul.pagination li a:hover {
            background-color: #e0e0e0;
        }

        ul.pagination li a.active {
            background-color: #2c3e50;
            color: white;
            border: 2px solid black;
        }

        ul.pagination li.prev-next a {
            width: auto;
            padding: 0 12px;
            border-radius: 20px;
            border: 1px solid #ccc;
        }

        ul.pagination li.prev-next a:hover {
            background-color: #ddd;
        }

        #card-color {
            color: #0023c0ff;
            font-weight: 600;
        }

        #main-product-div {
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        #main-product-div:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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

        .wishlist-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e0e0e0;
            z-index: 10;
        }

        .wishlist-icon:hover {
            background: white;
            border-color: #dc3545;
            transform: scale(1.1);
        }

        .wishlist-icon.active {
            color: #dc3545;
            border-color: #dc3545;
        }

        .wishlist-icon i {
            font-size: 1.2rem;
        }

        .login-popup {
            position: absolute;
            top: 50px;
            right: 0;
            background: #333;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .wishlist-icon:hover .login-popup {
            opacity: 1;
            visibility: visible;
        }

        .card-img-container {
            position: relative;
        }

        .off-price {
            display: flex;
            gap: 4px;
        }

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
    $is_active_category = false;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM categories WHERE categorie_id = '$id' AND categorie_status = 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $category_name = $row['categorie_name'];
            $is_active_category = true;
        }
    }
    ?>

    <main class="container py-4">

        <!-- msg -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-<?php echo $_GET['msg'] === 'addedtocart' ? 'success' : 'warning'; ?> alert-dismissible fade show mt-3"
                role="alert" id="CartAlert">
                <?php
                if ($_GET['msg'] === 'addedtocart')
                    echo "Product successfully added to cart.";
                elseif ($_GET['msg'] === 'alreadyincart')
                    echo "Product already in your cart.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="col-lg-2 text-center mt-1 my-5 py-2 detail-box" style="margin: auto; background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
            border-top: 3px solid #0077cc; border-bottom: 3px solid #0077cc;
            border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <h2 style="color: #0077cc; font-weight: 600; letter-spacing: 1px; font-family: 'Segoe UI', sans-serif;">
                Product</h2>
            <h6>
                <?php
                if ($is_active_category) {
                    echo "<div class='text-success' style='font-size: 13px;'>" . $category_name . "</div>";
                } else {
                    echo "Unknown Category";
                }
                ?>
            </h6>
        </div>
        <!-- product show -->
        <?php
        if (isset($_GET['id']) && $is_active_category) {
            $cateid = $_GET['id'];

            $limit = 4;
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            $showProduct = "SELECT * FROM product WHERE categorie_id=? AND product_status=? LIMIT {$offset}, {$limit}";
            $stmt = mysqli_prepare($conn, $showProduct);

            if ($stmt) {
                $product_status = 1;
                mysqli_stmt_bind_param($stmt, "ii", $cateid, $product_status);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="row g-4">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $product_id = $row['product_Id'];
                        $productimage = $row['product_image'];
                        $product_name = $row['product_name'];
                        $product_desc = $row['product_desc'];
                        $product_price = $row['product_price'];
                        $product_off = $row['product_off'];

                        $offprice = $product_price * $product_off / 100;
                        $finalPrice = $product_price - $offprice;

                        // Check if product is in user's wishlist
                        $is_in_wishlist = false;
                        if (isset($_SESSION['email'])) {
                            $user_email = $_SESSION['email'];
                            $user_query = "SELECT id FROM userdata WHERE email='$user_email'";
                            $user_res = mysqli_query($conn, $user_query);
                            $user_data = mysqli_fetch_assoc($user_res);
                            $user_id = $user_data['id'];

                            $wishlist_check = "SELECT * FROM wishlist WHERE user_id='$user_id' AND prod_id='$product_id'";
                            $wishlist_result = mysqli_query($conn, $wishlist_check);
                            $is_in_wishlist = (mysqli_num_rows($wishlist_result) > 0);
                        }

                        echo '<div class="col-12 mt-1 col-sm-6 col-md-4 col-lg-3">
                                <div class="card h-100 shadow-sm" id="main-product-div">
                                    <div class="card-img-container">
                                        <div class="p-3">
                                            <img src="./admin/images/product_img/' . htmlspecialchars($productimage) . '"
                                                class="card-img-top img-fluid" alt="Product Image"
                                                style="height: 250px; object-fit: contain; border-radius: 5px;">
                                        </div>';

                        // Wishlist icon
                        if (isset($_SESSION['email'])) {
                            echo '<div class="wishlist-icon ' . ($is_in_wishlist ? 'active' : '') . '" 
                                      onclick="toggleWishlist(' . $product_id . ', this)">
                                    <i class="bi bi-heart' . ($is_in_wishlist ? '-fill' : '') . '"></i>
                                  </div>';
                        } else {
                            echo '<div class="wishlist-icon" data-bs-toggle="modal" data-bs-target="#signInModal">
                                    <i class="bi bi-heart"></i>
                                    <div class="login-popup">Login to Wishlist</div>
                                  </div>';
                        }

                        echo '</div>
                                    <div class="card-body">
                                        <h6 class="card-title text-primary">' . htmlspecialchars($product_name) . '</h6>
                                        <p class="card-text" title="' . $product_desc . '">' . substr($product_desc, 0, 32) . '...</p>
                                        <div class="off-price">
                                        <li class="list-group-item"><b>Price:</b> ₹' . number_format((float) $finalPrice) . '</li>&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;<del style="color: #888;">₹' . number_format((float) $product_price) . '</del>
                                        <span style="color: red; font-style: italic; font-size: 14px; font-weight: 600;">' . htmlspecialchars($product_off) . '% Off</span>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        
                                    </ul>
                                    <div class="card-body text-center">';

                        // Add to Cart button with login check
                        if (isset($_SESSION['email'])) {
                            echo '<a href="./partials/productList_add_to_cart.php?product_id=' . $product_id . '" class="btn btn-primary me-2">
                                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                  </a>';
                        } else {
                            echo '<button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#signInModal">
                                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                  </button>';
                        }

                        echo '<a href="viewproduct.php?Productid=' . $product_id . '" class="btn btn-success">Quick View</a>
                                    </div>
                                </div>
                            </div>';
                    }
                    echo "</div><br><br>";
                } else {
                    echo '<div class="not-data text-center">
                            <div class="container">
                                <p class="display-5" style="font-weight: 500;">Sorry, no Product available in this category.</p><br>
                                <p class="lead"> We will update soon.</p>
                            </div>
                        </div><br><br>';
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<script>alert('Query preparation failed: " . mysqli_error($conn) . "');</script>";
            }
        } elseif (isset($_GET['id']) && !$is_active_category) {

            echo '<div class="not-data text-center">
                    <div class="container">
                        <p class="display-5" style="font-weight: 500;">Sorry, no Product available in this category.</p><br>
                        <p class="lead">Not available.</p>
                    </div>
                </div><br><br>';
        }
        ?>

        <!-- pagination -->
        <?php
        if (isset($_GET['id']) && $is_active_category) {
            $sql = "SELECT * FROM product WHERE categorie_id = '$cateid'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $total_product = mysqli_num_rows($result);
                $total_page = ceil($total_product / $limit);

                echo '<div class="d-flex justify-content-center mt-0">';
                echo '<ul class="pagination">';

                if ($page > 1) {
                    echo '<li class="prev-next"><a href="?id=' . $cateid . '&page=' . ($page - 1) . '">« Prev</a></li>';
                }

                for ($i = 1; $i <= $total_page; $i++) {
                    $active = ($i == $page) ? "active" : "";
                    echo '<li><a href="?id=' . $cateid . '&page=' . $i . '" class="' . $active . '">' . $i . '</a></li>';
                }

                if ($page < $total_page) {
                    echo '<li class="prev-next"><a href="?id=' . $cateid . '&page=' . ($page + 1) . '">Next »</a></li>';
                }

                echo '</ul>';
                echo '</div>';
            }
        }
        ?>
        <br>

        <!-- top product -->
        <div class="container-fluid top-deals-container">
            <div class="d-flex justify-content-between align-items-centermb-2">
                <div class="top-deals-title text-dark" style="font-weight: 700; margin-left: 20px;">
                    <?php echo $category_name; ?> Top Deals
                </div>
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
                    $categoryId = intval($_GET['id']);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $products = json_decode($row['product_details'], true);

                            if (is_array($products)) {
                                foreach ($products as $p) {

                                    $productName = mysqli_real_escape_string($conn, trim($p['product_name']));
                                    $qty = intval($p['quantity']);

                                    $checkQuery = "SELECT product_Id FROM product WHERE product_name = '$productName' AND categorie_id = $categoryId LIMIT 1";
                                    $checkRes = mysqli_query($conn, $checkQuery);
                                    if ($checkRes && mysqli_num_rows($checkRes) > 0) {
                                        if (!isset($productCounts[$productName])) {
                                            $productCounts[$productName] = 0;
                                        }
                                        $productCounts[$productName] += $qty;
                                    }
                                }
                            }
                        }
                    }

                    // top 8 products
                    arsort($productCounts);
                    $topProducts = array_slice($productCounts, 0, 8, true);

                    $productData = [];

                    foreach ($topProducts as $pname => $count) {
                        $query = "SELECT p.product_Id, p.product_name, p.product_image, p.categorie_id, p.product_price, c.categorie_name 
                       FROM product p INNER JOIN categories c ON p.categorie_id = c.categorie_id WHERE p.product_name = '" . mysqli_real_escape_string($conn, $pname) . "' AND p.categorie_id = $categoryId LIMIT 1";
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
                                    <a href="viewproduct.php?Productid=' . $product_id . '" class="text-decoration-none">
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

    <script>
        function toggleWishlist(productId, element) {
            $.ajax({
                url: 'partials/wishlist_ajax.php',
                type: 'POST',
                data: {
                    product_id: productId,
                    action: 'toggle'
                },
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        var icon = $(element).find('i');
                        if (result.action === 'added') {
                            $(element).addClass('active');
                            icon.removeClass('bi-heart').addClass('bi-heart-fill');
                        } else {
                            $(element).removeClass('active');
                            icon.removeClass('bi-heart-fill').addClass('bi-heart');
                        }

                        // Update wishlist count in header
                        if (result.wishlist_count !== undefined) {
                            $('.wishlist-count').text('(' + result.wishlist_count + ')');
                        }
                    } else {
                        alert(result.message);
                    }
                },
                error: function () {
                    alert('Error occurred. Please try again.');
                }
            });
        }


        $(document).ready(function () {
            $('.wishlist-icon[data-bs-toggle="modal"]').hover(
                function () {
                    $(this).addClass('active');
                },
                function () {
                    $(this).removeClass('active');
                }
            );
        });
    </script>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $('#CartAlert').slideUp(400);
            }, 1000);
        });
    </script>

</body>

</html>