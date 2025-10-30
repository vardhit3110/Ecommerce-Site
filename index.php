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
        <div class="col-lg-3 text-center my-5 mt-1 py-2 detail-box" style="margin: auto; background: linear-gradient(135deg, #f0f8ff, #e6f7ff);
            border-top: 3px solid #0077cc; border-bottom: 3px solid #0077cc;
            border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: all 0.3s ease;">
            <h2 style="color: #0077cc; font-weight: 600; letter-spacing: 1px; font-family: 'Segoe UI', sans-serif;">
                Featured Products</h2>
        </div>

        <!-- card -->
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
                echo '<div class="row g-4">';

                while ($row = mysqli_fetch_assoc($result)) {
                    $catid = $row['categorie_id'];
                    $catImage = $row['categorie_image'];
                    $catname = $row['categorie_name'];
                    $catdesc = $row['categorie_desc'];

                    echo '<div class="col-12 mt-1 col-sm-6 col-md-4">
                        <div class="card h-100" id="main-container">
                        <div class="p-3">
                        <img src="./admin/images/' . htmlspecialchars($catImage) . '" class="card-img-top" alt="' . htmlspecialchars($catname) . '" style="height: 370px; object-fit: contain; border-radius: 5px;">
                        </div>
                            <div class="card-body">
                                <h5 class="card-title" id="card-color">' . htmlspecialchars($catname) . '</h5>
                                <p class="card-text">' . htmlspecialchars($catdesc) . '</p>
                                <a href="viewproductList.php?id=' . $catid . '" class="btn btn-primary">View All</a>
                            </div>
                        </div>
                    </div>';
                }
                echo '</div><br><br>';
            } else {
                echo '<div class="not-data text-center">
                    <div class="container">
                        <p class="display-5" style="font-weight: 500;">Sorry, no Category available.</p><br>
                        <p class="lead"> We will update soon.</p>
                    </div>
                </div><br><br>';
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Query preparation failed: " . mysqli_error($conn) . "');</script>";
        }
        ?>
    </main>
    <?php require_once "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>