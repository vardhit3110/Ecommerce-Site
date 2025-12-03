<?php
require "slider.php";
include "db_connect.php";

/* total active users */
$usersql = "SELECT COUNT(*) AS total_users FROM userdata WHERE status='1'";
$userresult = mysqli_query($conn, $usersql);
if ($userresult) {
    $userrow = mysqli_fetch_assoc($userresult);
    $users = $userrow['total_users'];
} else {
    echo "Error (users): " . mysqli_error($conn);
}

/* total orders */
$ordersql = "SELECT COUNT(*) AS total_orders FROM orders WHERE order_status IN ('1', '2', '3')";
$orderresult = mysqli_query($conn, $ordersql);
if ($orderresult) {
    $orderrow = mysqli_fetch_assoc($orderresult);
    $orders = $orderrow['total_orders'];
} else {
    echo "Error (orders): " . mysqli_error($conn);
}

/* total revenue */
$revenuesql = "SELECT SUM(total_amount) AS grand_total FROM orders WHERE order_status='4'";
$revenueresult = mysqli_query($conn, $revenuesql);
if ($revenueresult) {
    $revenueRow = mysqli_fetch_assoc($revenueresult);
    $totalRevenue = $revenueRow['grand_total'] ?? 0;
} else {
    echo "Error (revenue): " . mysqli_error($conn);
}

/* today Revenue */
$today = date('Y-m-d');
$revenuesql = "SELECT SUM(total_amount) AS today_total FROM orders WHERE order_status = '4' AND DATE(order_date) = '$today'";
$revenueresult = mysqli_query($conn, $revenuesql);
if ($revenueresult) {
    $revenueRow = mysqli_fetch_assoc($revenueresult);
    $todayRevenue = $revenueRow['today_total'] ?? 0;
}
mysqli_close($conn);


$targetCount = 1203794;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
    <?php include "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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
        }

        .card {
            background-color: #fffcfcff;
        }

        small.text-muted {
            font-size: 0.85rem;
        }

        .fw-semibold {
            font-weight: 600;
        }

        #btn {
            border-radius: 25px;
        }

        .leaflet-container {
            height: 250px;
            border-radius: 12px;
        }

        .chart-container {
            position: relative;
            height: 220px;
            width: 100%;
        }

        .target-box {
            background: #f9fafb;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            width: 75px;
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
         /* Loader styles from Uiverse.io by alexruix */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            width: 80px;
            height: 50px;
            position: relative;
        }

        .loader-text {
            position: absolute;
            top: 0;
            padding: 0;
            margin: 0;
            color: #C8B6FF;
            animation: text_713 3.5s ease both infinite;
            font-size: .8rem;
            letter-spacing: 1px;
        }

        .load {
            background-color: #9A79FF;
            border-radius: 50px;
            display: block;
            height: 16px;
            width: 16px;
            bottom: 0;
            position: absolute;
            transform: translateX(64px);
            animation: loading_713 3.5s ease both infinite;
        }

        .load::before {
            position: absolute;
            content: "";
            width: 100%;
            height: 100%;
            background-color: #D1C2FF;
            border-radius: inherit;
            animation: loading2_713 3.5s ease both infinite;
        }

        @keyframes text_713 {
            0% {
                letter-spacing: 1px;
                transform: translateX(0px);
            }

            40% {
                letter-spacing: 2px;
                transform: translateX(26px);
            }

            80% {
                letter-spacing: 1px;
                transform: translateX(32px);
            }

            90% {
                letter-spacing: 2px;
                transform: translateX(0px);
            }

            100% {
                letter-spacing: 1px;
                transform: translateX(0px);
            }
        }

        @keyframes loading_713 {
            0% {
                width: 16px;
                transform: translateX(0px);
            }

            40% {
                width: 100%;
                transform: translateX(0px);
            }

            80% {
                width: 16px;
                transform: translateX(64px);
            }

            90% {
                width: 100%;
                transform: translateX(0px);
            }

            100% {
                width: 16px;
                transform: translateX(0px);
            }
        }

        @keyframes loading2_713 {
            0% {
                transform: translateX(0px);
                width: 16px;
            }

            40% {
                transform: translateX(0%);
                width: 80%;
            }

            80% {
                width: 100%;
                transform: translateX(0px);
            }

            90% {
                width: 80%;
                transform: translateX(15px);
            }

            100% {
                transform: translateX(0px);
                width: 16px;
            }
        }
    </style>
</head>

<body>
     <div class="loader-container" id="loader">
        <div class="loader">
            <span class="loader-text">loading</span>
            <span class="load"></span>
        </div>
    </div>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-money-check-dollar"></i> Payouts</h1>
            <div class="user-profile">
                <i class="fa-solid fa-layer-group fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <div class="p-2 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="col-span-2 space-y-4">

                    <!-- Add Font Awesome CDN in <head> -->
                    <link rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

                    <!-- Updated Customers & Orders Section -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Customers Card -->
                        <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-sm font-semibold text-gray-500">Users</h2>
                                <p class="text-2xl font-bold mt-2"><?php $userCount = number_format($users); ?><span
                                        id="userCount">0</span></p>
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">+11.01%</span>
                            </div>
                            <div class="text-indigo-600 bg-indigo-100 p-3 rounded-xl">
                                <i class="fa-solid fa-users text-xl"></i>
                            </div>
                        </div>

                        <!-- Orders Card -->
                        <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center justify-between">
                            <div>
                                <h2 class="text-sm font-semibold text-gray-500">Orders</h2>
                                <p class="text-2xl font-bold mt-2"><?php $ordersCount = number_format($orders); ?><span
                                        id="ordersCount">0</span></p>
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">-9.05%</span>
                            </div>
                            <div class="text-red-600 bg-red-100 p-3 rounded-xl">
                                <i class="fa-solid fa-box text-xl"></i>
                            </div>
                        </div>
                    </div>


                    <!-- Monthly Sales -->
                    <div class="bg-white rounded-2xl shadow-sm p-4">
                        <h2 class="text-sm font-semibold mb-2 text-gray-700">Monthly Sales</h2>
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE (Monthly Target without graph) -->
                <div class="bg-white rounded-2xl shadow-sm p-6 flex flex-col items-center justify-center">
                    <h2 class="text-sm font-semibold text-gray-500 mb-2">Monthly Target</h2>
                    <p class="text-xl font-bold mt-2"><?php $sales = $totalRevenue * 100 / $targetCount;
                    $monthlySaleResult = number_format($sales, 2);
                    ?>
                        <span id="monthlySaleResult">0</span>%
                    </p>
                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full mt-1">+10%</span>
                    <p class="text-gray-500 text-xs mt-2 text-center">You earned $3287 today, higher than last month.
                    </p>

                    <div class="flex justify-center gap-3 mt-4 text-xs flex-wrap">
                        <div class="target-box">
                            <p class="text-gray-400 text-[11px]">Target</p>
                            <p class="text-gray-800 font-semibold">
                                ₹<span id="targetCount">0</span>
                            </p>
                        </div>
                        <div class="target-box">
                            <p class="text-gray-400 text-[11px]">Revenue</p>
                            <p class="text-gray-800 font-semibold">₹
                                <?php
                                function shortAmount($amount)
                                {
                                    if ($amount >= 1000000000) {
                                        return round($amount / 1000000000, 1) . 'B';
                                    } elseif ($amount >= 1000000) {
                                        return round($amount / 1000000, 1) . 'M';
                                    } elseif ($amount >= 1000) {
                                        return round($amount / 1000, 1) . 'K';
                                    } else {
                                        return $amount;
                                    }
                                }
                                // echo shortAmount($totalRevenue);
                                ?>
                                <span id="revenueCount">0</span>
                            </p>

                        </div>
                        <div class="target-box">
                            <p class="text-gray-400 text-[11px]">Today</p>
                            <p class="text-gray-800 font-semibold">₹
                                <span id="todayRevenue">0</span>
                                <?php
                                // echo shortAmount($todayRevenue);
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function formatNumber(num) {
                    if (num >= 1e9) return (num / 1e9).toFixed(1) + 'B';
                    if (num >= 1e6) return (num / 1e6).toFixed(1) + 'M';
                    if (num >= 1e3) return (num / 1e3).toFixed(1) + 'K';
                    return num;
                }

                function animateCounter(elementId, finalCount, duration = 2000) {
                    const elem = document.getElementById(elementId);
                    let currentCount = 0;
                    const increment = finalCount / (duration / 20);

                    const counter = setInterval(() => {
                        currentCount += increment;
                        if (currentCount >= finalCount) {
                            currentCount = finalCount;
                            clearInterval(counter);
                        }
                        elem.textContent = formatNumber(Math.floor(currentCount));
                    }, 20);
                }
                animateCounter('revenueCount', <?php echo $totalRevenue; ?>);
                animateCounter('todayRevenue', <?php echo $todayRevenue; ?>);
                animateCounter('targetCount', <?php echo $targetCount; ?>);
                animateCounter('monthlySaleResult', <?php echo $monthlySaleResult; ?>);
            </script>
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

                animateCounter('userCount', <?php echo $userCount; ?>);
                animateCounter('ordersCount', <?php echo $ordersCount; ?>);
            </script>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                <!-- Active Countries-->
                <div class="bg-white rounded-2xl shadow-sm p-3 w-[95%]">
                    <h2 class="text-md font-semibold mb-2">Active Countries</h2>
                    <div id="worldMap"></div>

                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between border-b pb-2">
                            <div class="flex items-center gap-3">
                                <img src="https://flagcdn.com/w20/in.png" class="w-6 h-6 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-700">India</p>
                                    <p class="text-xs text-gray-500">Total Users: 1,240</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">⭐ 4.8 Rating</p>
                        </div>

                        <div class="flex items-center justify-between border-b pb-2">
                            <div class="flex items-center gap-3">
                                <img src="https://flagcdn.com/w20/us.png" class="w-6 h-6 rounded-full">
                                <div>
                                    <p class="font-semibold text-gray-700">USA</p>
                                    <p class="text-xs text-gray-500">Total Users: 950</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">⭐ 4.6 Rating</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Payouts (Bootstrap Table) -->
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <h2 class="text-md font-semibold mb-3">Recent Payouts</h2>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Country</th>
                                    <th>CR</th>
                                    <th class="text-end">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="https://flagcdn.com/w20/in.png" class="me-2"> <span
                                            style="font-size: 12px;">India</span></td>
                                    <td>INR</td>
                                    <td class="text-success text-end fw-semibold">$1,250</td>
                                </tr>
                                <tr>
                                    <td><img src="https://flagcdn.com/w20/us.png" class="me-2"> <span
                                            style="font-size: 12px;">USA</span></td>
                                    <td>USD</td>
                                    <td class="text-success text-end fw-semibold">$980</td>
                                </tr>
                                <tr>
                                    <td><img src="https://flagcdn.com/w20/gb.png" class="me-2">
                                        <span style="font-size: 12px;">UK</span>
                                    </td>
                                    <td>GBP</td>
                                    <td class="text-success text-end fw-semibold">$765</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // Monthly Sales Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [120, 380, 200, 290, 180, 190],
                        backgroundColor: '#4F46E5',
                        borderRadius: 6,
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                        x: { grid: { display: false } }
                    },
                    interaction: { mode: 'index', intersect: false },
                    onHover: (e, chartEl) => e.native.target.style.cursor = chartEl.length ? 'crosshair' : 'default'
                }
            });

            // Leaflet Map
            const map = L.map('worldMap').setView([20, 0], 2);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '' }).addTo(map);
        </script>

        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
  <script>
        // Hide loader once the page fully loads
        window.addEventListener("load", function () {
            const loader = document.getElementById('loader');
            const tableContainer = document.getElementById('table-container');
            loader.style.display = 'none';
            tableContainer.style.display = 'block';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>