<?php require "slider.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <?php include "links/icons.html"; ?>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --accent: #7209b7;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .stat-icon {
            font-size: 30px;
            margin-bottom: 10px;
            display: block;
        }

        .dashboard-container {
            padding: 20px;
        }

        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--light);
            padding: 10px 15px;
            border-radius: 8px;
        }

        .user-info h4 {
            margin: 0;
            color: var(--dark);
        }

        .user-info p {
            margin: 0;
            color: var(--gray);
            font-size: 14px;
        }

        .content-area {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 20px;
        }

        .dynamic-content h2 {
            color: var(--primary);
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 20px;
        }

        .dashboard-card {
            flex: 1 1 calc(25% - 30px);
            min-width: 250px;
            height: 140px;
            background-color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            text-align: left;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            color: #333;
            position: relative;
            overflow: hidden;
            border-left: 5px solid;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .dashboard-card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .dashboard-card .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .dashboard-card .card-content h3 {
            font-size: 14px;
            margin-bottom: 8px;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dashboard-card .card-content h4 {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .dashboard-card .card-trend {
            display: flex;
            align-items: center;
            font-size: 12px;
            margin-top: 5px;
            color: #27ae60;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        /* Individual Card Colors */
        .dashboard-card1 {
            border-left-color: #3498db;
        }

        .dashboard-card1 .card-icon {
            background: linear-gradient(135deg, #3498db, );
        }

        .dashboard-card2 {
            border-left-color: #2ecc71;
        }

        .dashboard-card2 .card-icon {
            background: linear-gradient(135deg, #2ecc71, );
        }

        .dashboard-card3 {
            border-left-color: #e74c3c;
        }

        .dashboard-card3 .card-icon {
            background: linear-gradient(135deg, #e74c3c, );
        }

        .dashboard-card4 {
            border-left-color: #f39c12;
        }

        .dashboard-card4 .card-icon {
            background: linear-gradient(135deg, #f39c12, );
        }

        .dashboard-card5 {
            border-left-color: #9b59b6;
        }

        .dashboard-card5 .card-icon {
            background: linear-gradient(135deg, #9b59b6, );
        }

        .dashboard-card6 {
            border-left-color: #1abc9c;
        }

        .dashboard-card6 .card-icon {
            background: linear-gradient(135deg, #1abc9c, );
        }

        .dashboard-card7 {
            border-left-color: #34495e;
        }

        .dashboard-card7 .card-icon {
            background: linear-gradient(135deg, #34495e, );
        }

        .card-row {
            display: flex;
            width: 100%;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card-row:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 1200px) {
            .dashboard-card {
                flex: 1 1 calc(50% - 30px);
            }
        }

        @media (max-width: 768px) {
            .card-row {
                flex-direction: column;
            }

            .dashboard-card {
                flex: 1 1 100%;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Welcome, <?php echo $email; ?></h1>
            <div class="user-area">

                <div class="user-profile">
                    <i class="fa fa-user-secret fa-2x" aria-hidden="true"></i>&nbsp;
                    <div class="user-info">
                        <h4><?php echo substr($email, 0, strpos($_SESSION['email'], "@")); ?></h4>
                        <p>Administrator</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require "db_connect.php";

        $counts = [];
        $tables = ['userdata', 'categories', 'product', 'wishlist', 'feedback', 'orders'];
        foreach ($tables as $table) {
            $existSql = "SELECT * FROM $table";
            $result = mysqli_query($conn, $existSql);
            $numExistRows = mysqli_num_rows($result);
            $counts[$table] = $numExistRows;
        }
        ?>
        <!-- Content Area -->
        <div class="content-area">
            <div class="dynamic-content">
                <h2><i class="fas fa-home" style="color: #3598DB;"></i> Dashboard Overview</h2>

                <div class="card-container">
                    <!-- First Row - 4 Boxes -->
                    <div class="card-row">
                        <div class="dashboard-card dashboard-card1">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Users</h3>
                                    <h4><?php echo $counts['userdata']; ?></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-users" style="color: #3498db;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card2">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Categories</h3>
                                    <h4><?php echo $counts['categories']; ?></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-tags" style="color: #2ecc71;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card3">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Products</h3>
                                    <h4><?php echo $counts['product']; ?></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-box" style="color: #e74c3c;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card4">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Wishlist</h3>
                                    <h4><?php echo $counts['wishlist']; ?></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-heart" style="color: #f39c12;;"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row - 3 Boxes -->
                    <div class="card-row">
                        <div class="dashboard-card dashboard-card5">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Feedback</h3>
                                    <h4><?php echo $counts['feedback']; ?></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-comments" style="color: #9b59b6;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card6">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Orders</h3>
                                    <h4><?php ?><?php echo $counts['orders']; ?></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-shopping-cart" style="color: #1abc9c;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card7">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Reviews</h3>
                                    <h4><?php ?>0</h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-star" style="color: #34495e;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>