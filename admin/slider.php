<?php
require "db_connect.php";
session_start();
$email = $_SESSION['email'];
if ($email == true) {

} else {
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="../store/images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/slider.css">
</head>

<body>
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <img src="../store/images/owner.jpeg" alt="Logo">
            <span>Admin Panel</span>
        </div>
        <ul class="nav-links">
            <li class="active">
                <a href="dashboard.php">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle">
                    <i class="fa-solid fa-chart-simple"></i>
                    <span>Orders List</span>
                </a>
                <ul class="submenu">
                    <li><a href="order_list.php">All Orders</a></li>
                    <li><a href="cancelled_order.php">Cancelled Orders</a></li>
                    <li><a href="delivered_order.php">Delivered Orders</a></li>
                </ul>
            </li>
            <li>
                <a href="category_list.php">
                    <i class="fa-solid fa-folder-plus"></i>
                    <span>Category List</span>
                </a>
            </li>

            <li>
                <a href="product_list.php">
                    <i class="fa-solid fa-square-list"></i>
                    <span>Subcategory</span>
                </a>
            </li>

            <li>
                <a href="users_data.php">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <li>
                <a href="feedbackList.php">
                    <i class="fa-solid fa-messages"></i>
                    <span>Feedback</span>
                </a>
            </li>

            <li>
                <a href="subscribers-manage.php">
                    <i class="fa-solid fa-bell"></i>
                    <span>Subscribers</span>
                </a>
            </li>

            <li>
                <a href="coupons.php">
                    <i class="fa fa-tags"></i>
                    <span>Coupons</span>
                </a>
            </li>

            <li>
                <a href="adminProfile.php">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <span>Admin Profile</span>
                </a>
            </li>

            <li>
                <a href="payout.php">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    <span>Payouts</span>
                </a>
            </li>

            <li>
                <a href="user_contact.php">
                    <i class="fa-solid fa-envelope"></i>
                    <span>User Contact</span>
                </a>
            </li>

            <li>
                <a href="banner.php">
                    <i class="fa-solid fa-image-stack"></i>
                    <span>Web Banner</span>
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
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
        });

        document.addEventListener('click', function (event) {
            if (window.innerWidth <= 768 &&
                !sidebar.contains(event.target) &&
                event.target !== menuToggle &&
                !menuToggle.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });

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

        // Dropdown toggle
        document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                const parent = this.parentElement;
                parent.classList.toggle('open');
            });
        });
    </script>
</body>

</html>