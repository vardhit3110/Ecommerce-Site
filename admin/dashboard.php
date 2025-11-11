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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .analytics-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            width: 900px;
            padding: 30px;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .title {
            color: #111827;
            font-size: 22px;
            font-weight: 600;
        }

        .subtitle {
            color: #6b7280;
            font-size: 14px;
        }

        .tabs {
            display: flex;
            background: #f3f4f6;
            border-radius: 10px;
            overflow: hidden;
        }

        .tab {
            padding: 8px 20px;
            cursor: pointer;
            color: #6b7280;
            font-weight: 500;
            transition: all 0.3s;
            border-right: 1px solid #e5e7eb;
            user-select: none;
        }

        .tab:last-child {
            border-right: none;
        }

        .tab.active {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        canvas {
            margin-top: 20px;
        }

        .profit-box {
            text-align: center;
            margin-top: 15px;
            background-color: #dbffe4ff;
            color: #16a34a;
            font-weight: 600;
            font-size: 13px;
            width: 160px;
            border-radius: 7px;
            display: none;
        }

        .profit-box.visible {
            display: block;
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
        $tables = ['userdata', 'categories', 'product', 'wishlist', 'feedback', 'subscriber'];
        foreach ($tables as $table) {
            $existSql = "SELECT * FROM $table";
            $result = mysqli_query($conn, $existSql);
            $numExistRows = mysqli_num_rows($result);
            $counts[$table] = $numExistRows;
        }

        /* order Count */
        $sql = "SELECT COUNT(*) AS total_orders FROM orders WHERE order_status IN ('1', '2', '3')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $orders = $row['total_orders'];
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_close($conn);
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
                                    <?php $userCount = $counts['userdata']; ?>
                                    <h4><span id="userCount">0</span></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-users" style="color: #3498db;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card2">
                            <div class="card-header">
                                <div class="card-content">
                                    <?php $categoriesCount = $counts['categories']; ?>
                                    <h3>Total Categories</h3>
                                    <h4><span id="categoriesCount">0</span></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-tags" style="color: #2ecc71;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card3">
                            <div class="card-header">
                                <div class="card-content">
                                    <?php $productsCount = $counts['product']; ?>
                                    <h3>Total Products</h3>
                                    <h4><span id="productsCount">0</span></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-box" style="color: #e74c3c;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card4">
                            <div class="card-header">
                                <div class="card-content">
                                    <?php $wishlistCount = $counts['wishlist']; ?>
                                    <h3>Total Wishlist</h3>
                                    <h4><span id="wishlistCount">0</span></h4>
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
                                    <?php $feedbackCount = $counts['feedback']; ?>
                                    <h4><span id="feedbackCount">0</span></h4>
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
                                    <?php $orders; ?>
                                    <h4><span id="ordersCount">0</span></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-shopping-cart" style="color: #1abc9c;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="dashboard-card dashboard-card7">
                            <div class="card-header">
                                <div class="card-content">
                                    <h3>Total Subscribers</h3>
                                    <?php $subscribersCount = $counts['subscriber']; ?>
                                    <h4><span id="subscribersCount">0</span></h4>
                                </div>
                                <div class="card-icon">
                                    <i class="fas fa-bell" style="color: #34495e;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function animateCounter(elementId, finalCount, duration = 2000) {
                        const elem = document.getElementById(elementId);
                        let currentCount = 0;
                        const increment = Math.ceil(finalCount / (duration / 20));

                        const counter = setInterval(() => {
                            currentCount += increment;
                            if (currentCount >= finalCount) {
                                currentCount = finalCount;
                                clearInterval(counter);
                            }
                            elem.textContent = currentCount;
                        }, 20);
                    }

                    // Start the counters
                    animateCounter('userCount', <?php echo $userCount; ?>);
                    animateCounter('categoriesCount', <?php echo $categoriesCount; ?>);
                    animateCounter('productsCount', <?php echo $productsCount; ?>);
                    animateCounter('wishlistCount', <?php echo $wishlistCount; ?>);
                    animateCounter('feedbackCount', <?php echo $feedbackCount; ?>);
                    animateCounter('ordersCount', <?php echo $orders; ?>);
                    animateCounter('subscribersCount', <?php echo $subscribersCount; ?>);
                </script>
            </div>
        </div>

        <!-- Graph -->
        <div class="content-area">
            <div class="header">
                <div>
                    <div class="title">Analytics</div>
                    <div class="subtitle">Visitor analytics of last 12 months</div>
                </div>
                <div class="tabs">
                    <div class="tab active" data-period="12months">12 months</div>
                    <div class="tab" data-period="30days">30 days</div>
                    <div class="tab" data-period="7days">7 days</div>
                    <div class="tab" data-period="24hours">24 hours</div>
                </div>
            </div>
            <canvas id="analyticsChart" height="110"></canvas>
            <center>
                <div class="profit-box" id="profitBox"></div>
            </center>
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
    <script>
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        const profitBox = document.getElementById('profitBox');

        // Static Data
        const chartData = {
            "12months": {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                data: [120, 168, 90, 280, 150, 170, 260, 95, 190, 360, 270, 100],
                product: ["Camera", "Headphones", "Watch", "Laptop", "Tablet", "Phone", "Speaker", "Keyboard", "Monitor", "Console", "Earbuds", "Drone"],
                title: "Visitor analytics of last 12 months",
                profit: "₹2,253K"
            },
            "30days": {
                labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
                data: [240, 310, 290, 340],
                product: ["Week 1 Sales", "Week 2 Sales", "Week 3 Sales", "Week 4 Sales"],
                title: "Visitor analytics of last 30 days",
                profit: "₹1,180K"
            },
            "7days": {
                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                data: [120, 180, 100, 250, 200, 300, 220],
                product: ["Camera", "Laptop", "Tablet", "Speaker", "Console", "Drone", "Phone"],
                title: "Visitor analytics of last 7 days",
                profit: "₹450K"
            },
            "24hours": {
                labels: ["1 AM", "4 AM", "7 AM", "10 AM", "1 PM", "4 PM", "7 PM", "10 PM"],
                data: [5, 10, 15, 22, 30, 20, 18, 12],
                product: ["Product 1", "Product 2", "Product 3", "Product 4", "Product 5", "Product 6", "Product 7", "Product 8"],
                title: "Visitor analytics of last 24 hours",
                profit: "₹22K"
            }
        };

        let current = "12months";

        // Create Chart
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData[current].labels,
                datasets: [{
                    data: chartData[current].data,
                    backgroundColor: '#3B82F6',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e5e7eb' },
                        ticks: { color: '#374151' }
                    },
                    x: {
                        ticks: { color: '#374151' }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#111',
                        bodyColor: '#111',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: (context) => {
                                const data = chartData[current];
                                return [`${data.product[context.dataIndex]}`, `Sales: ${data.data[context.dataIndex]}`];
                            }
                        }
                    }
                },
                animation: { duration: 800 }
            }
        });

        function updateChart(period) {
            current = period;
            const data = chartData[period];
            chart.data.labels = data.labels;
            chart.data.datasets[0].data = data.data;
            chart.update();

            document.querySelector('.subtitle').textContent = data.title;
            profitBox.textContent = `Total Profit: ${data.profit}`;
            profitBox.classList.add('visible');
        }

        // Tab Click
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                updateChart(tab.dataset.period);
            });
        });

        // Show profit for default tab (12 months)
        profitBox.textContent = `Total Profit: ${chartData[current].profit}`;
        profitBox.classList.add('visible');
    </script>
</body>

</html>