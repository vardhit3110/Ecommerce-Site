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
      background-color: #ffffff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #0077cc;
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
      color: #333;
      font-weight: 500;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #0077cc;
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

    .sign-in {
      background-color: transparent;
      color: #0077cc;
      border: 2px solid #0077cc;
    }

    .sign-in:hover {
      background-color: #0077cc;
      color: white;
    }

    .sign-up {
      background-color: transparent;
      color: #0077cc;
      border: 2px solid #0077cc;
    }

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
    <div class="logo">MobileSite</div>

    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <nav id="main-nav">
      <a href="#">Home</a>
      <a href="#">About Us</a>
      <a href="#">Contact</a>
    </nav>

    <div class="auth-buttons" id="auth-buttons">
      <button class="sign-in">Sign In</button>
      <button class="sign-up">Sign Up</button>
    </div>
  </header>

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
