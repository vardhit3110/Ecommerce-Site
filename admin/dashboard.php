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
        <link rel="stylesheet" href="assets/dashboard.css">
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