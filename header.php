<?php
require "db_connect.php";
@session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MobileSite</title>
  <?php require "links/icons.html"; ?>
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
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #f39c12;
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

    @media (max-width: 768px) {
      .menu-toggle {
        display: block;
      }

      nav,
      .auth-buttons,
      .user-dropdown {
        width: 100%;
        flex-direction: column;
        display: none;
        margin-top: 10px;
        animation: fadeIn 0.3s ease-in-out;
      }

      nav.active,
      .auth-buttons.active,
      .user-dropdown.active {
        display: flex;
      }

      .user-dropdown-content {
        position: static;
        box-shadow: none;
        width: 100%;
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
  </style>
</head>

<body>

  <header>
    <div class="logo"><i class="fa fa-mobile" aria-hidden="true"></i> MobileSite</div>

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


      <a href="#">About Us</a>
      <a href="#">Contact Us</a>
    </nav>

    <?php if (isset($_SESSION['email'])): ?>
      <!-- User dropdown when logged in -->
      <div class="user-dropdown" id="user-dropdown">
        <button class="user-dropdown-btn">
          <img src="" alt="User" class="user-avatar"
            onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0id2hpdGUiPjxwYXRoIGQ9Ik0xMiAxMmMxLjY1IDAgMy0xLjM1IDMtM3MtMS4zNS0zLTMtMy0zIDEuMzUtMyAzIDEuMzUgMyAzIDN6bTAgMWMtMS42NiAwLTUgLjgzLTUgMi41VjE3aDEwdjEuNWMwLTEuNjctMy4zNC0yLjUtNS0yLjV6Ii8+PC9zdmc+'">
          <span><?php echo $_SESSION['username']; ?></span>
          <i class="fa fa-chevron-down"></i>
        </button>
        <div class="user-dropdown-content">
          <a href="viewprofile.php?email=<?php echo $_SESSION['email']; ?>"><i class="fa fa-user"></i> Profile</a>

          <!-- wishlist Count -->
          <?php
          $user_email = $_SESSION['email'];
          $user_query = "SELECT id FROM userdata WHERE email='$user_email'";
          $user_res = mysqli_query($conn, $user_query);
          $user_data = mysqli_fetch_assoc($user_res);
          $user_id = $user_data['id'];

          $count_query = "SELECT COUNT(*) AS total FROM wishlist WHERE user_id='$user_id'";
          $count_res = mysqli_query($conn, $count_query);
          $count_row = mysqli_fetch_assoc($count_res);
          $wishlist_count = $count_row['total'];
          ?>
          
          <a href="wishlist.php"><i class="fa-solid fa-heart"></i> Wishlist
            &nbsp; <span class="text-danger wishlist-count"><b>(<?php echo $wishlist_count; ?>)</b></span>
          </a>

          <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
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
            <button type="submit" class="btn btn-success" name="register" style="font-weight: 600;">
              Create Account
            </button>
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
                style="text-decoration: none;">Create Account</a>
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
  </script>
  <script>
    function toggleMenu() {
      const nav = document.getElementById("main-nav");
      const auth = document.getElementById("auth-buttons");
      const userDropdown = document.getElementById("user-dropdown");

      nav.classList.toggle("active");

      if (auth) {
        auth.classList.toggle("active");
      }

      if (userDropdown) {
        userDropdown.classList.toggle("active");
      }
    }
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
        $_SESSION['id'] = $row['id'];
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