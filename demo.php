<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Header</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
      color: #eee;
    }

    .menu-toggle {
      display: none;
      font-size: 24px;
      cursor: pointer;
      background: none;
      border: none;
      color: #0077cc;
    }

    nav {
      display: flex;
      gap: 25px;
    }

    nav a {
      text-decoration: none;
      color: white;
      font-weight: 500;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #f82c2cff;
    }

    .auth-buttons {
      display: flex;
      gap: 15px;
    }

    .auth-buttons button {
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s, color 0.3s;
    }

    .sign-in,
    .sign-up {
      background-color: transparent;
      color: #0077cc;
      border: 2px solid #0077cc;
    }

    .sign-in:hover,
    .sign-up:hover {
      background-color: #0077cc;
      color: white;
    }

    @media (max-width: 768px) {
      .menu-toggle {
        display: block;
      }

      nav,
      .auth-buttons {
        width: 100%;
        flex-direction: column;
        gap: 15px;
        display: none;
        margin-top: 10px;
      }

      nav.active,
      .auth-buttons.active {
        display: flex;
      }

      header {
        align-items: flex-start;
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
      <!-- Trigger Bootstrap Modals -->
      <button class="sign-in" data-bs-toggle="modal" data-bs-target="#signInModal">Sign In</button>
      <button class="sign-up" data-bs-toggle="modal" data-bs-target="#signUpModal">Sign Up</button>
    </div>
  </header>

  <!-- Sign In Modal -->
  <div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title" id="signInModalLabel">Sign In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="signin-email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="signin-email" required>
            </div>
            <div class="mb-3">
              <label for="signin-password" class="form-label">Password</label>
              <input type="password" class="form-control" id="signin-password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Sign In</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Sign Up Modal -->
  <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form>
          <div class="modal-header">
            <h5 class="modal-title" id="signUpModalLabel">Sign Up</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="signup-name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="signup-name" required>
            </div>
            <div class="mb-3">
              <label for="signup-email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="signup-email" required>
            </div>
            <div class="mb-3">
              <label for="signup-password" class="form-label">Password</label>
              <input type="password" class="form-control" id="signup-password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Sign Up</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function toggleMenu() {
      const nav = document.getElementById("main-nav");
      const auth = document.getElementById("auth-buttons");
      nav.classList.toggle("active");
      auth.classList.toggle("active");
    }
  </script>

</body>

</html>
