<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Header</title>
  <?php require "links/icons.html"; ?>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

    @media (max-width: 768px) {
      .menu-toggle {
        display: block;
      }

      nav,
      .auth-buttons {
        width: 100%;
        flex-direction: column;
        display: none;
        margin-top: 10px;
        animation: fadeIn 0.3s ease-in-out;
      }

      nav.active,
      .auth-buttons.active {
        display: flex;
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
      <a href="#">About Us</a>
      <a href="#">Contact Us</a>
    </nav>

    <div class="auth-buttons" id="auth-buttons">
      <button class="sign-in" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</button>
      <button class="sign-up" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign Up</button>
    </div>
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
              Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-toggle="modal"
                data-bs-target="#signUpModal" style="text-decoration: none;">Create Account</a>
            </p>
            <button type="submit" class="btn btn-success" name="login" style="font-weight: 600;">Login</button>
          </div>
        </form>
        <script>
          $(document).ready(function () {
            $("#myForm").validate({
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
                  required: "Please enter your email address",
                  email: "Please enter a valid email address"
                },
                password: {
                  required: "Please provide a password",
                  minlength: "Your password must be at least 6 characters long"
                }
              },
              submitHandler: function (form) {
                /*  */
                form.submit();
              }
            });
          });
        </script>
      </div>
    </div>
  </div>

  <!-- validation sign in / sign up -->
  <script>
    $(document).ready(function () {
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
            minlength: "Your name must be at least 2 characters"
          },
          email: {
            required: "Please enter your email address",
            email: "Please enter a valid email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 6 characters long"
          }
        },
        submitHandler: function (form) {
          form.submit();
        }
      });

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
            required: "Please enter your email address",
            email: "Please enter a valid email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 6 characters long"
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
      nav.classList.toggle("active");
      auth.classList.toggle("active");
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>