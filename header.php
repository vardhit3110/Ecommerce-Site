<?php
require "db_connect.php";
if (session_status() == PHP_SESSION_NONE) {
  @session_start();
}
$base_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/";

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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MobileSite</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .categoryname {
      font-size: 14px;
    }

    .dropdown-toggle {
      background-color: transparent;
      color: white;
      text-decoration: none;
      display: inline-block;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: white;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-menu a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown:hover .dropdown-menu {
      display: block;
    }

    .dropdown-menu a:hover {
      background-color: #f1f1f1;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: #2c3e50;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #fff;
    }

    .menu-toggle {
      display: none;
      font-size: 28px;
      cursor: pointer;
      background: none;
      border: none;
      color: #fff;
    }

    nav {
      display: flex;
      gap: 25px;
    }

    nav a {
      text-decoration: none !important;
      color: #fff;
      font-weight: 500;
      transition: color 0.3s;
      border-bottom: none !important;
    }

    nav a:hover {
      color: #f39c12;
      text-decoration: none !important;
      border-bottom: none !important;
    }

    .auth-buttons {
      display: flex;
      gap: 3px;
    }

    .auth-buttons button {
      padding: 8px 18px;
      border: none;
      border-radius: 4px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s, color 0.3s, border 0.3s;
    }

    .sign-in {
      background-color: transparent;
      color: white;
      border: 2px solid #f39c12;
    }

    .sign-in:hover {
      background-color: #f39c12;
      color: #000000ff;
    }

    .sign-up {
      background-color: transparent;
      color: white;
      border: 2px solid #f39c12;
    }

    .sign-up:hover {
      background-color: #f39c12;
      color: #000000ff;
    }

    /* User dropdown styles */
    .user-dropdown {
      position: relative;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-dropdown-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      background: none;
      border: 2px solid #f39c12;
      border-radius: 30px;
      padding: 6px 12px;
      color: white;
      cursor: pointer;
      transition: background 0.3s;
    }

    .user-dropdown-btn:hover {
      color: black;
      background-color: #f39c12;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #fff;
    }

    .user-dropdown-content {
      display: none;
      position: absolute;
      top: 100%;
      right: 0;
      background-color: #fff;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      z-index: 1;
      border-radius: 4px;
      overflow: hidden;
      margin-top: 5px;
    }

    .user-dropdown-content a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      transition: background 0.3s;
    }

    .user-dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .user-dropdown:hover .user-dropdown-content {
      display: block;
    }

    /* Enhanced Cart Button Styles */
    .cart-container {
      position: relative;
      margin-right: 15px;
    }

    .cart-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      background: none;
      border: 2px solid #f39c12;
      border-radius: 30px;
      padding: 8px 16px;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      font-weight: 500;
      position: relative;
    }

    .cart-btn:hover {
      background-color: #f39c12;
      color: #000;
      text-decoration: none;
    }

    .cart-icon {
      font-size: 18px;
    }

    .cart-count {
      background-color: #e74c3c;
      color: white;
      border-radius: 50%;
      width: 22px;
      height: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: bold;
      position: absolute;
      top: -8px;
      right: -5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Cart Dropdown Styles */
    .cart-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      width: 350px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      z-index: 1001;
      display: none;
      margin-top: 10px;
      overflow: hidden;
    }

    .cart-container:hover .cart-dropdown {
      display: block;
      animation: fadeIn 0.3s ease-in-out;
    }

    .cart-dropdown-header {
      padding: 15px;
      border-bottom: 1px solid #eee;
      background-color: #f8f9fa;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .cart-dropdown-header .view-all {
      font-size: 14px;
      color: #3498db;
      text-decoration: none;
      font-weight: normal;
    }

    .cart-dropdown-body {
      max-height: 300px;
      overflow-y: auto;
    }

    .cart-item {
      display: flex;
      padding: 12px 15px;
      border-bottom: 1px solid #f1f1f1;
      transition: background 0.2s;
      align-items: center;
      position: relative;
    }

    .cart-item:hover {
      background-color: #f9f9f9;
    }

    .cart-item-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
      margin-right: 12px;
      border: 1px solid #eee;
    }

    .cart-item-details {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .cart-item-name {
      font-weight: 600;
      font-size: 14px;
      color: #333;
      margin-bottom: 5px;
      line-height: 1.3;
    }

    .cart-item-price {
      font-weight: 600;
      color: #e74c3c;
      font-size: 15px;
    }

    .cart-dropdown-footer {
      padding: 15px;
      border-top: 1px solid #eee;
      background-color: #f8f9fa;
      text-align: center;
    }

    .cart-total {
      display: flex;
      justify-content: space-between;
      margin-bottom: 12px;
      font-weight: 600;
    }

    .cart-dropdown-footer .btn {
      width: 100%;
      background-color: #f39c12;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 6px;
      font-weight: 600;
      transition: background 0.3s;
    }

    .cart-dropdown-footer .btn:hover {
      background-color: #e67e22;
    }

    .empty-cart {
      padding: 30px 15px;
      text-align: center;
      color: #7f8c8d;
    }

    .empty-cart i {
      font-size: 40px;
      margin-bottom: 10px;
      color: #bdc3c7;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    @media (max-width: 768px) {
      .menu-toggle {
        display: block;
      }

      nav,
      .auth-buttons,
      .user-dropdown,
      .cart-container {
        width: 100%;
        flex-direction: column;
        display: none;
        margin-top: 10px;
        animation: fadeIn 0.3s ease-in-out;
      }

      nav.active,
      .auth-buttons.active,
      .user-dropdown.active,
      .cart-container.active {
        display: flex;
      }

      .user-dropdown-content {
        position: static;
        box-shadow: none;
        width: 100%;
      }

      .cart-dropdown {
        position: static;
        width: 100%;
        margin-top: 10px;
        box-shadow: none;
        border: 1px solid #ddd;
      }

      .header-right {
        width: 100%;
        flex-direction: column;
        gap: 10px;
      }

      .cart-btn {
        width: 100%;
        justify-content: center;
      }

      header {
        align-items: flex-start;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-5px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .remove-from-cart-btn {
      background-color: transparent;
      color: #fe3636ff;
      font-weight: 500;
      border: none;
      border-radius: 50%;
      width: 25px;
      height: 25px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 12px;
      transition: all 0.3s ease;
      margin-left: 10px;
      flex-shrink: 0;
    }

    .remove-from-cart-btn:hover {
      /* background-color: #c0392b; */
      transform: scale(1.1);
    }
  </style>
</head>

<body>

  <header>
    <div class="logo"><i class="fa fa-mobile" aria-hidden="true"></i><?php echo $systemName; ?></div>

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <nav id="main-nav">
      <a href="home.php">Home</a>

      <?php

      $showCategories = "SELECT * FROM categories WHERE categorie_status=?";
      $stmt = mysqli_prepare($conn, $showCategories);

      if ($stmt) {
        $categorie_status = 1;
        mysqli_stmt_bind_param($stmt, "i", $categorie_status);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
          ?>
          <div class="dropdown">
            <a href="index.php" class="dropdown-toggle">Categories</a>
            <div class="dropdown-menu">
              <?php
              while ($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['categorie_id'];
                $category_name = htmlspecialchars($row['categorie_name']);
                ?>
                <a href="<?php echo "viewproductList.php?id=$category_id"; ?>">
                  <h6 class="categoryname"><?php echo $category_name; ?></h6>
                </a>
                <?php
              }
              ?>
            </div>
          </div>
          <?php
        }
      }
      ?>

      <a href="about.php">About Us</a>
      <a href="#">Contact Us</a>
      <a href="<?php echo isset($_SESSION['email']) ? 'feedback.php' : '#'; ?>" onclick="<?php if (!isset($_SESSION['email']))
               echo 'alert(\'Please log in to give feedback.\')'; ?>">Feedback</a>
    </nav>

    <!-- Searching -->
    <form class="d-flex" id="searchForm" style="margin-left:20px;">
      <input class="form-control me-2" type="search" name="query" id="searchInput" placeholder="Search products..."
        aria-label="Search" autocomplete="off">
      <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
      <div id="searchResult" style="position:absolute; background:white; width:300px; max-height:300px; overflow-y:auto;
              box-shadow:0 4px 8px rgba(0,0,0,0.1); display:none; z-index:9999;"></div>
    </form>

    <?php if (isset($_SESSION['email'])): ?>
      <?php

      $user_email = $_SESSION['email'];

      $user_query = "SELECT id FROM userdata WHERE email='$user_email'";
      $user_res = mysqli_query($conn, $user_query);
      $user_data = mysqli_fetch_assoc($user_res);
      $user_id = $user_data['id'];

      $cart_count_query = "SELECT COUNT(*) AS total FROM viewcart WHERE user_id='$user_id'";
      $cart_count_res = mysqli_query($conn, $cart_count_query);
      $cart_count_row = mysqli_fetch_assoc($cart_count_res);
      $cart_count = $cart_count_row['total'];

      /* Product Limit Handle  */
      $cart_items = [];
      $cart_total = 0;

      $cart_query = "SELECT vc.*, p.product_name, p.product_price, p.product_image FROM viewcart vc JOIN product p ON vc.product_id = p.product_Id WHERE vc.user_id = '$user_id'";

      $cart_result = mysqli_query($conn, $cart_query);

      if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        while ($item = mysqli_fetch_assoc($cart_result)) {

          $product_image = "admin/images/product_img/" . $item['product_image'];

          if (!file_exists($product_image)) {
            $product_image = "https://via.placeholder.com/60x60?text=No+Image";
          }

          $item_total = $item['product_price'] * $item['quantity'];
          $cart_total += $item_total;
          $cart_items[] = [
            'product_id' => $item['product_id'],
            'product_name' => $item['product_name'],
            'product_price' => $item['product_price'],
            'product_image' => $product_image,
            'quantity' => $item['quantity']
          ];
        }
      }
      ?>

      <div class="header-right">
        <div class="cart-container" id="cart-container">
          <a href="viewcart.php" class="cart-btn">
            <i class="fa fa-shopping-cart cart-icon"></i>
            Cart
            <?php if ($cart_count > 0): ?>
              <span class="cart-count"><?php echo $cart_count; ?></span>
            <?php endif; ?>
          </a>

          <div class="cart-dropdown">
            <div class="cart-dropdown-header">
              <span>Your Cart (<?php echo $cart_count; ?>)</span>
              <a href="viewcart.php" class="view-all">View All</a>
            </div>

            <div class="cart-dropdown-body">
              <?php if ($cart_count > 0): ?>
                <?php foreach ($cart_items as $item): ?>
                  <div class="cart-item">
                    <img src="<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>"
                      class="cart-item-img" onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
                    <div class="cart-item-details">
                      <div class="cart-item-name"><?php echo $item['product_name']; ?></div>
                      <div class="cart-item-price">
                        ₹<?php echo number_format($item['product_price'], 2); ?> x <?php echo $item['quantity']; ?>
                      </div>
                    </div>

                    <button class="remove-from-cart-btn" data-product-id="<?php echo $item['product_id']; ?>"
                      title="Remove from cart">Remove
                      <!-- <i class="fa fa-times"></i> -->
                    </button>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="empty-cart">
                  <i class="fa fa-shopping-cart"></i>
                  <p>Your cart is empty</p>
                </div>
              <?php endif; ?>
            </div>

            <?php if ($cart_count > 0): ?>
              <div class="cart-dropdown-footer">
                <div class="cart-total">
                  <span>Total:</span>
                  <span>₹<?php echo number_format($cart_total, 2); ?></span>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- User Dropdown -->
        <div class="user-dropdown" id="user-dropdown">
          <?php

          $wish_count_query = "SELECT COUNT(*) AS total FROM wishlist WHERE user_id='$user_id'";
          $wish_res = mysqli_query($conn, $wish_count_query);
          $wish_row = mysqli_fetch_assoc($wish_res);
          $wishlist_count = $wish_row['total'];
          ?>

          <button class="user-dropdown-btn">
            <img
              src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0id2hpdGUiPjxwYXRoIGQ9Ik0xMiAxMmMxLjY1IDAgMy0xLjM1IDMtM3MtMS4zNS0zLTMtMy0zIDEuMzUtMyAzIDEuMzUgMyAzIDN6bTAgMWMtMS42NiAwLTUgLjgzLTUgMi41VjE3aDEwdjEuNWMwLTEuNjctMy4zNC0yLjUtNS0yLjV6Ii8+PC9zdmc+"
              alt="User" class="user-avatar">
            <span><?php echo $_SESSION['username']; ?></span>
            <i class="fa fa-chevron-down"></i>
          </button>
          <div class="user-dropdown-content">
            <a href="viewprofile.php?email=<?php echo $_SESSION['email']; ?>">
              <i class="fa fa-user"></i> Profile
            </a>

            <a href="myorder.php">
              <i class="fa-duotone fa-solid fa-boxes-stacked"></i> Orders
              <span class="text-danger"></span>
            </a>

            <a href="wishlist.php">
              <i class="fa-solid fa-heart"></i> Wishlist
              <span class="text-danger">(<?php echo $wishlist_count; ?>)</span>
            </a>

            <a href="userfeedback.php">
              <i class="fa-solid fa-star"></i> Your Feedback
            </a>

            <a href="logout.php">
              <i class="fa fa-sign-out"></i> Logout
            </a>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="auth-buttons" id="auth-buttons">
        <button class="sign-in" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</button>
        <button class="sign-up" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign Up</button>
      </div>
    <?php endif; ?>
  </header>


  <!-- Sign Up Modal -->
  <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" id="signUpForm">
          <div class="modal-header bg-success">
            <h5 class="modal-title text-light" id="signUpModalLabel">Sign Up</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label for="username"><i class="fa fa-user"></i> User Name</label>
              <input type="text" name="username" id="username" class="form-control" placeholder="Enter Your Name"
                required minilength="2">
            </div>

            <div class="mb-3 mt-2">
              <label for="email"><i class="fa fa-envelope"></i> Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email" required
                minlength="5">
            </div>

            <div class="mb-3 mt-2">
              <label for="password"><i class="fa fa-lock"></i> Password</label>
              <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter Your Password" required minlength="6">
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between align-items-center w-100">
            <p class="mb-0" style="font-weight: 600; color: navy;">
              I have an Account <a href="#" data-bs-toggle="modal" data-bs-target="#signInModal"
                style="text-decoration: none;">Login</a>
            </p>
            <button type="submit" class="btn btn-success" name="register" style="font-weight: 600;">Create
              Account</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Sign In Modal -->
  <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" id="signInForm">
          <div class="modal-header bg-success">
            <h5 class="modal-title text-light" id="signInModalLabel">Sign In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="col-mb-3">
              <label for="email"><i class="fa fa-envelope"></i> Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email" required>
              <div id="emailError" class="error"></div>
            </div>

            <div class="col mb-3 mt-3">
              <label for="password"><i class="fa fa-lock"></i> Password</label>
              <input type="password" name="password" id="password" class="form-control"
                placeholder="Enter Your Password" required>
              <div id="passwordError" class="error"></div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between align-items-center w-100">
            <p class="mb-0" style="font-weight: 600; color: navy;">
              Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal"
                style="text-decoration: none;">Create Account</a><br>

              Forgot your password? <a href="ResetPassword.php" style="text-decoration: none;">Reset here</a>
            </p>
            <button type="submit" class="btn btn-success" name="login" style="font-weight: 600;">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      /* sign Up validation*/
      $("#signUpForm").validate({
        rules: {
          username: {
            required: true,
            minlength: 2
          },
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 6
          }
        },
        messages: {
          username: {
            required: "Please enter your name",
            minlength: "Name must be at least 2 characters long"
          },
          email: {
            required: "Please enter your email",
            email: "Please enter a valid email"
          },
          password: {
            required: "Please enter a password",
            minlength: "Password must be at least 6 characters long"
          }
        },
        submitHandler: function (form) {
          form.submit();
        }
      });

      /* sign in validation*/
      $("#signInForm").validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          password: {
            required: true,
            minlength: 6
          }
        },
        messages: {
          email: {
            required: "Please enter your email",
            email: "Please enter a valid email"
          },
          password: {
            required: "Please enter a password",
            minlength: "Password must be at least 6 characters long"
          }
        },
        submitHandler: function (form) {
          form.submit();
        }
      });
    });

    function toggleMenu() {
      const nav = document.getElementById("main-nav");
      const auth = document.getElementById("auth-buttons");
      const userDropdown = document.getElementById("user-dropdown");
      const cartContainer = document.getElementById("cart-container");

      nav.classList.toggle("active");

      if (auth) {
        auth.classList.toggle("active");
      }

      if (userDropdown) {
        userDropdown.classList.toggle("active");
      }

      if (cartContainer) {
        cartContainer.classList.toggle("active");
      }
    }
  </script>
  <script>
    $(document).on('click', '.remove-from-cart-btn', function (e) {
      e.preventDefault();
      e.stopPropagation();

      var productId = $(this).data('product-id');
      var $cartItem = $(this).closest('.cart-item');
      var $cartContainer = $(this).closest('.cart-container');

      if (confirm('Are you sure you want to remove this item from cart?')) {
        $.ajax({
          url: 'partials/remove_from_cart.php',
          type: 'POST',
          data: {
            product_id: productId
          },
          success: function (response) {
            console.log('Response:', response);

            if (response.success) {
              $cartItem.remove();
              var newCount = response.cart_count;
              var $cartCount = $('.cart-count');
              if (newCount > 0) {
                $cartCount.text(newCount).show();
              } else {
                $cartCount.hide();
              }
              $('.cart-dropdown-header span').text('Your Cart (' + newCount + ')');
              if (newCount === 0) {
                $('.cart-dropdown-body').html('<div class="empty-cart"><i class="fa fa-shopping-cart"></i><p>Your cart is empty</p></div>');
                $('.cart-dropdown-footer').hide();
              } else {

                if ($('.cart-item').length === 0) {
                  $('.cart-dropdown-footer').hide();
                }
              }

              alert(response.message);
            } else {
              alert('Error: ' + response.error);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
            alert('Error removing item from cart. Please try again.');
          }
        });
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
/* sign up */
if (isset($_POST['register'])) {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];

  $check_email = "SELECT * FROM userdata WHERE email = ?";
  $stmt = mysqli_prepare($conn, $check_email);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result_email = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result_email) > 0) {
    echo "<script>alert('Email Already Registered');</script>";
  } else {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $reg_query = "INSERT INTO userdata (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $reg_query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
      echo "<script>alert('Register Successful!');</script>";
    } else {
      echo "<script>alert('Registration Failed. Please try again later.');</script>";
    }
  }
}

/* sign in model */
if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  $stmt = mysqli_prepare($conn, "SELECT username, email, password, status FROM userdata WHERE email = ?");
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
      if ($row['status'] == 1) {
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['status'] = $row['status'];

        echo "<script>alert('Login Successful!'); window.location.href = window.location.href;</script>";
        exit();
      } else {
        echo "<script>alert('Login failed. This account has been blocked.');</script>";
      }
    } else {
      echo "<script>alert('Incorrect password.');</script>";
    }
  } else {
    echo "<script>alert('Email not registered.');</script>";
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>