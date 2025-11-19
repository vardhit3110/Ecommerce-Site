<?php
$tooltipText = "Our HTML editor updates the webview automatically in real-time as you write code.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
    .tooltip {
      position: relative;
      display: inline-block;
      cursor: pointer;
    }

    .tooltip-text {
      visibility: hidden;
      opacity: 0;
      width: 250px;
      background: rgba(0, 0, 0, 0.85);
      color: #fff;
      padding: 8px 12px;
      border-radius: 6px;
      position: absolute;
      left: 0;
      top: 120%;
      transition: opacity 0.3s ease;
      pointer-events: none;
      z-index: 999;
    }

    .tooltip:hover .tooltip-text {
      visibility: visible;
      opacity: 1;
    }
  </style>

</head>

<body>
  <?php 
  include "db_connect.php";
  ?>

  <p class="tooltip">
    hello..,
    <span class="tooltip-text">
      <?= $tooltipText; ?>
    </span>
  </p>
  <?php
  $sql = "SELECT product_details FROM orders WHERE order_status = '4'";
  $result = mysqli_query($conn, $sql);

  $productCounts = [];
  $categoryId = intval($_GET['id']); // URL category
  
  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $products = json_decode($row['product_details'], true);

      if (is_array($products)) {
        foreach ($products as $p) {

          $productName = mysqli_real_escape_string($conn, trim($p['product_name']));
          $qty = intval($p['quantity']);

          // find product in DB with same name + category
          $checkQuery = "SELECT product_Id FROM product 
                               WHERE product_name = '$productName' 
                               AND categorie_id = $categoryId 
                               LIMIT 1";

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
    $query = "SELECT p.product_Id, p.product_name, p.product_image, 
                     p.categorie_id, p.product_price, c.categorie_name 
              FROM product p 
              INNER JOIN categories c ON p.categorie_id = c.categorie_id 
              WHERE p.product_name = '" . mysqli_real_escape_string($conn, $pname) . "' 
              AND p.categorie_id = $categoryId 
              LIMIT 1";

    $res = mysqli_query($conn, $query);
    if ($res && mysqli_num_rows($res) > 0) {
      $data = mysqli_fetch_assoc($res);
      $data['count'] = $count;
      $productData[] = $data;
    }
  }
  ?>


</body>

</html>