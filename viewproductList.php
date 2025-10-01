<?php
include "db_connect.php";
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

        #main-product-div {
            border-radius: 10px;
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
                Product</h2>
        </div>

        <!-- product show -->

        <?php
        if (isset($_GET['id'])) {
            $cateid = $_GET['id'];

            $showProduct = "SELECT * FROM product WHERE categorie_id=? AND product_status=?";
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

                        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm" id="main-product-div">
                        <div class="p-3">
                            <img src="./admin/images/product_img/' . htmlspecialchars($productimage) . '"
                                class="card-img-top img-fluid" alt="Product Image"
                                style="height: 250px; object-fit: contain; border-radius: 5px;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-primary">' . htmlspecialchars($product_name) . '</h5>
                            <p class="card-text">' . substr($product_desc, 0, 90) . '...</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Price:</b> ₹' . number_format((float) $row['product_price']) . '</li>
                        </ul>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary me-2">Add to Cart</a>
                            <a href="viewproduct.php?id=' . $product_id . '" class="btn btn-success">Quick View</a>
                        </div>
                    </div>
                </div>';
                    }
                    echo "</div><br><br>";
                } else {
                    echo '<div class="not-data text-center">
                    <div class="container">
                        <p class="display-5" style="font-weight: 500;>Sorry, no Product available in this category.</p><br>
                        <p class="lead"> We will update soon.</p>
                    </div>
                </div><br><br>';
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "<.script>alert('Query preparation failed: " . mysqli_error($conn) . "');</script>";
            }
        }
        ?>
    </main>
    <?php require_once "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>