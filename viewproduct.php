<?php
session_start();
include "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MobileSite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        #box-detail {
            color: black;
        }

        #box {
            border-radius: 15px;
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
    </style>
</head>

<body>

    <?php require_once "header.php"; ?>

    <main class="container py-4">
        <div class="col-lg-2 text-center my-5 py-2 detail-box" style="margin: auto; background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
            border-top: 3px solid #0077cc; border-bottom: 3px solid #0077cc;
            border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <h2 style="color: #0077cc; font-weight: 600; letter-spacing: 1px; font-family: 'Segoe UI', sans-serif;">
                Detail
            </h2>
        </div>

        <?php
        if (isset($_GET['Productid'])) {
            $productid = $_GET['Productid'];

            $showProduct = "SELECT p.*, c.categorie_name FROM product p 
                            JOIN categories c ON p.categorie_id = c.categorie_id 
                            WHERE p.product_Id = ? AND p.product_status = '1' AND c.categorie_status = '1'";

            $stmt = mysqli_prepare($conn, $showProduct);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $productid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="container my-5 bg-light" id="box">';

                    while ($row = mysqli_fetch_assoc($result)) {
                        $product_id = $row['product_Id'];
                        $productimage = $row['product_image'];
                        $product_name = $row['product_name'];
                        $product_desc = $row['product_desc'];
                        $product_price = $row['product_price'];
                        $category_name = $row['categorie_name'];
                        ?>

                        <div class="row shadow p-4 rounded align-items-center" id="box-detail">
                            <div class="col-md-4 text-center mb-3 mb-md-0">
                                <h6><?php echo htmlspecialchars($category_name); ?></h6>
                                <img src="./admin/images/product_img/<?php echo htmlspecialchars($productimage); ?>"
                                    class="card-img-top img-fluid rounded" alt="<?php echo htmlspecialchars($product_name); ?>"
                                    style="max-height: 250px; object-fit: contain;">
                            </div>

                            <div class="col-md-8">
                                <h4 class="fw-bold mb-2"><?php echo htmlspecialchars($product_name); ?></h4>
                                <p class="text-muted mb-2">
                                    <?php echo nl2br(htmlspecialchars($product_desc)); ?>
                                </p>

                                <h5 class="text-danger mb-3">₹<?php echo number_format((float) $product_price); ?></h5><br>
                                <div class="mb-3">
                                    <a href="#" class="btn btn-primary me-2">Add to Cart</a>

                                    <?php if (isset($_SESSION['id'])): ?>
                                        <form method="POST" action="./partials/Add_wishlist.php" style="display:inline;">
                                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-heart"></i> Add to Wishlist
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="login.php" class="btn btn-outline-danger">
                                            <i class="bi bi-heart"></i> Login to Wishlist
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo '</div>';
                } else {
                    echo '<div class="not-data text-center">
                <div class="container">
                    <p class="display-5" style="font-weight: 500;">Sorry, Product not found.</p><br>
                    <p class="lead"> We will update soon.</p>
                </div>
            </div><br><br>';
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<script>alert('Query preparation failed: " . mysqli_error($conn) . "');</script>";
            }
        }
        ?>
    </main>

    <?php require_once "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>