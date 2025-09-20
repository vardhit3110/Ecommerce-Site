<?php
require "db_connect.php";
session_start();
$email = $_SESSION['email'];
if ($email == true) {

} else {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 70px;
            --sidebar-expanded-width: 250px;
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #9b59b6;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-expanded-width);
            height: 100vh;
            background: linear-gradient(160deg, var(--secondary-color) 0%, var(--dark-color) 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: var(--transition);
            overflow: hidden;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        }

        .logo {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .logo img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .logo span {
            color: white;
            font-size: 20px;
            font-weight: 600;
            white-space: nowrap;
        }

        .nav-links {
            padding: 20px 0;
        }

        .nav-links li {
            list-style: none;
            position: relative;
        }

        .nav-links li:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-links li.active {
            background: rgba(255, 255, 255, 0.15);
        }

        .nav-links li.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-color);
        }

        .nav-links a {
            display: flex;
            align-items: center;
            height: 50px;
            text-decoration: none;
            padding: 0 20px;
            white-space: nowrap;
            color: rgba(255, 255, 255, 0.8);
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: white;
        }

        .nav-links i {
            font-size: 22px;
            min-width: 40px;
            text-align: center;
            margin-right: 15px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-expanded-width);
            transition: var(--transition);
            padding: 20px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .header h1 {
            color: var(--dark-color);
            font-size: 28px;
            font-weight: 700;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .notification {
            position: relative;
            cursor: pointer;
        }

        .notification i {
            font-size: 22px;
            color: var(--dark-color);
        }

        .notification .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 12px;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .user-info h4 {
            color: var(--dark-color);
            font-weight: 600;
        }

        .user-info p {
            color: var(--primary-color);
            font-size: 14px;
        }

        .nav-links .logout {
            bottom: -425px;
        }

        /* Content Area */
        .content-area {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dynamic-content {
            text-align: center;
            color: #777;
        }

        .dynamic-content i {
            font-size: 64px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .dynamic-content h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .dynamic-content p {
            font-size: 16px;
            max-width: 600px;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 14px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                z-index: 1000;
            }

            .sidebar.mobile-open {
                width: var(--sidebar-expanded-width);
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .user-area {
                justify-content: center;
            }

            .menu-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1001;
                background: var(--primary-color);
                color: white;
                border: none;
                border-radius: 5px;
                width: 40px;
                height: 40px;
                font-size: 20px;
                cursor: pointer;
            }
        }

        .menu-toggle {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Menu Toggle Button (Mobile Only) -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iI2ZmZiI+PHBhdGggZD0iTTEyIDJDNi40OCAyIDIgNi40OCAyIDEyczQuNDggMTAgMTAgMTAgMTAtNC40OCAxMC0xMFMxNy41MiAyIDEyIDJ6bTAgMThjLTQuNDEgMC04LTMuNTktOC04czMuNTktOCA4LTggOCAzLjU5IDggOC0zLjU5IDgtOCA4em0tMS00aDJ2NEgxMXYtNHptMS0xMGMtLjU1IDAtMSAuNDUtMSAxdjZjMCAuNTUuNDUgMSAxIDFzMS0uNDUgMS0xVjZjMC0uNTUtLjQ1LTEtMS0xeiIvPjwvc3ZnPg=="
                alt="Logo">
            <span>Admin Panel</span>
        </div>
        <ul class="nav-links">
            <li class="active">
                <a href="dashboard.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="users_data.php">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <li>
                <a href="category_list.php">
                    <i class="fa-duotone fa-solid fa-folder-plus"></i>
                    <span>Category List</span>
                </a>
            </li>


            <li class="logout">
                <a href="partials/_logout.php">
                    <i class="fa fa-sign-out"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>



    <script>
        // Mobile menu toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (event) {
            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                event.target !== menuToggle &&
                !menuToggle.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Update active menu item based on current page
        document.addEventListener('DOMContentLoaded', function () {
            const currentPage = window.location.pathname.split('/').pop();
            const menuItems = document.querySelectorAll('.nav-links a');

            menuItems.forEach(item => {
                const href = item.getAttribute('href');
                if (href === currentPage || (currentPage === '' && href === 'dashboard.html')) {
                    item.parentElement.classList.add('active');
                } else {
                    item.parentElement.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>