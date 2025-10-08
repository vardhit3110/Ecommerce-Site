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
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: var(--primary);
            font-weight: 600;
            margin: 0;
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
            height: 130px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            color: #333;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            transition: width 0.3s;
        }
        
        .dashboard-card:hover:before {
            width: 10px;
        }
        
        .dashboard-card1 {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
        }
        
        .dashboard-card1:before {
            background: #28a745;
        }
        
        .dashboard-card2 {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
        }
        
        .dashboard-card2:before {
            background: #17a2b8;
        }
        
        .dashboard-card3 {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        }
        
        .dashboard-card3:before {
            background: #dc3545;
        }
        
        .dashboard-card4 {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        }
        
        .dashboard-card4:before {
            background: #ffc107;
        }
        
        .dashboard-card5 {
            background: linear-gradient(135deg, #e2e3e5, #d6d8db);
        }
        
        .dashboard-card5:before {
            background: #6c757d;
        }
        
        .dashboard-card6 {
            background: linear-gradient(135deg, #d6d8f5, #c7c9f0);
        }
        
        .dashboard-card6:before {
            background: #6f42c1;
        }
        
        .dashboard-card7 {
            background: linear-gradient(135deg, #cce7ff, #b3d9ff);
        }
        
        .dashboard-card7:before {
            background: #007bff;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .dashboard-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .dashboard-card h4 {
            font-size: 28px;
            font-weight: 700;
            color: #222;
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
        
        .footer {
            background: var(--dark);
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
        }
        
        .stat-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
            opacity: 0.7;
        }
    </style>
</head>

<body>
    <!-- Main Content -->
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
        $tables = ['userdata', 'categories', 'product', 'wishlist', 'feedback'];
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
                <h2><i class="fas fa-home"></i> Dashboard Overview</h2>

                <div class="card-container">
                    <!-- First Row - 4 Boxes -->
                    <div class="card-row">
                        <div class="dashboard-card dashboard-card1">
                            <i class="fas fa-users stat-icon"></i>
                            <h3><strong>Total Users</strong></h3>
                            <h4><?php echo $counts['userdata']; ?></h4>
                        </div>
                        <div class="dashboard-card dashboard-card2">
                            <i class="fas fa-tags stat-icon"></i>
                            <h3><strong>Total Categories</strong></h3>
                            <h4><?php echo $counts['categories']; ?></h4>
                        </div>
                        <div class="dashboard-card dashboard-card3">
                            <i class="fas fa-box stat-icon"></i>
                            <h3><strong>Total Products</strong></h3>
                            <h4><?php echo $counts['product']; ?></h4>
                        </div>
                        <div class="dashboard-card dashboard-card4">
                            <i class="fas fa-heart stat-icon"></i>
                            <h3><strong>Total Wishlist</strong></h3>
                            <h4><?php echo $counts['wishlist']; ?></h4>
                        </div>
                    </div>
                    
                    <!-- Second Row - 3 Boxes -->
                    <div class="card-row">
                        <div class="dashboard-card dashboard-card5">
                            <i class="fas fa-comments stat-icon"></i>
                            <h3><strong>Total Feedback</strong></h3>
                            <h4><?php echo $counts['feedback']; ?></h4>
                        </div>
                        <div class="dashboard-card dashboard-card6">
                            <i class="fas fa-shopping-cart stat-icon"></i>
                            <h3><strong>Total Orders</strong></h3>
                            <h4><?php echo $counts['orders']; ?></h4>
                        </div>
                        <div class="dashboard-card dashboard-card7">
                            <i class="fas fa-star stat-icon"></i>
                            <h3><strong>Total Reviews</strong></h3>
                            <h4><?php echo $counts['reviews']; ?></h4>
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

    <script>
        // Add animation to cards when they come into view
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
            
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'opacity 0.5s, transform 0.5s';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>

</html>