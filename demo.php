<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Total Payouts Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f5f7fb;
            font-family: "Poppins", sans-serif;
        }

        .dashboard-container {
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .chart-card {
            position: relative;
        }

        .summary-card {
            border-radius: 12px;
            padding: 18px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .summary-card h4 {
            margin-bottom: 5px;
            font-size: 22px;
            font-weight: 600;
            color: #2b2b2b;
        }

        .summary-card p {
            margin: 0;
            color: #777;
            font-size: 14px;
        }

        .table thead {
            background-color: #007bff;
            color: #fff;
        }

        .country-flag {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .amount {
            color: #198754;
            font-weight: 600;
        }

        .map-card img {
            border-radius: 10px;
            width: 100%;
            height: auto;
        }

        .country-item {
            display: flex;
            align-items: center;
            margin-top: 8px;
        }

        .country-item img {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .country-item small {
            color: #777;
            font-size: 13px;
        }

        canvas {
            cursor: crosshair;
        }
    </style>
</head>

<body>

    <div class="dashboard-container container-fluid">
        <h3 class="mb-4 fw-bold text-primary">💰 Total Payouts Dashboard</h3>

        <!-- Charts Row -->
        <div class="row g-4">
            <!-- Monthly Sales -->
            <div class="col-lg-8">
                <div class="card p-4 chart-card">
                    <h5 class="fw-semibold mb-3">📈 Monthly Sales Overview</h5>
                    <canvas id="salesChart" height="140"></canvas>
                </div>
            </div>

            <!-- Target Progress -->
            <div class="col-lg-4">
                <div class="card p-4 text-center">
                    <h5 class="fw-semibold mb-3">🎯 Monthly Target Progress</h5>
                    <canvas id="targetChart" height="170"></canvas>
                    <!-- Target Summary Cards -->

                </div>
            </div>
        </div>

        <!-- Map + Table Row -->
        <div class="row g-4 mt-4">
            <!-- Map Section -->
            <div class="col-lg-4">
                <div class="card p-3 map-card">
                    <h5 class="fw-semibold mb-3">🌍 Active Countries</h5>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/80/World_map_-_low_resolution.svg"
                        alt="World Map">
                    <div class="mt-3">
                        <div class="country-item">
                            <img src="https://flagcdn.com/w20/in.png" alt="India">
                            <div>
                                <strong>India</strong><br>
                                <small>4,520 active users</small>
                            </div>
                        </div>
                        <div class="country-item">
                            <img src="https://flagcdn.com/w20/us.png" alt="USA">
                            <div>
                                <strong>USA</strong><br>
                                <small>1,240 active users</small>
                            </div>
                        </div>
                        <div class="country-item">
                            <img src="https://flagcdn.com/w20/gb.png" alt="UK">
                            <div>
                                <strong>United Kingdom</strong><br>
                                <small>780 active users</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payouts Table -->
            <div class="col-lg-8">
                <div class="card p-4">
                    <h5 class="fw-semibold mb-3">💼 Recent Payouts</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Country</th>
                                    <th>Date</th>
                                    <th>Orders</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><img src="https://randomuser.me/api/portraits/men/32.jpg" class="country-flag">
                                    </td>
                                    <td>Ravi Kumar</td>
                                    <td>🇮🇳 India</td>
                                    <td>01 Nov 2025</td>
                                    <td>15</td>
                                    <td class="amount">₹2,450</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><img src="https://randomuser.me/api/portraits/men/76.jpg" class="country-flag">
                                    </td>
                                    <td>Arjun Singh</td>
                                    <td>🇮🇳 India</td>
                                    <td>02 Nov 2025</td>
                                    <td>12</td>
                                    <td class="amount">₹1,980</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><img src="https://randomuser.me/api/portraits/men/51.jpg" class="country-flag">
                                    </td>
                                    <td>Rahul Mehta</td>
                                    <td>🇮🇳 India</td>
                                    <td>03 Nov 2025</td>
                                    <td>18</td>
                                    <td class="amount">₹2,950</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><img src="https://randomuser.me/api/portraits/men/88.jpg" class="country-flag">
                                    </td>
                                    <td>Vikas Patel</td>
                                    <td>🇮🇳 India</td>
                                    <td>04 Nov 2025</td>
                                    <td>10</td>
                                    <td class="amount">₹1,200</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Monthly Sales Chart
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const gradient = ctxSales.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(13,110,253,0.3)');
        gradient.addColorStop(1, 'rgba(13,110,253,0.05)');

        new Chart(ctxSales, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov'],
                datasets: [{
                    label: 'Total Sales (₹)',
                    data: [5000, 7000, 8500, 9500, 10000, 12500, 15000, 13000, 14000, 15500, 14580],
                    borderColor: '#0d6efd',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointRadius: 0,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#0d6efd',
                        titleColor: '#fff',
                        bodyColor: '#fff'
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: '#e9ecef' } }
                },
                hover: {
                    mode: 'nearest',
                    intersect: false
                }
            },
            plugins: [{
                // Plugin to draw crosshair line
                afterDatasetsDraw: function (chart) {
                    const { ctx, tooltip, chartArea: { top, bottom, left, right } } = chart;
                    if (tooltip._active && tooltip._active.length) {
                        const x = tooltip._active[0].element.x;
                        ctx.save();
                        ctx.beginPath();
                        ctx.moveTo(x, top);
                        ctx.lineTo(x, bottom);
                        ctx.lineWidth = 1;
                        ctx.setLineDash([4, 4]);
                        ctx.strokeStyle = '#999';
                        ctx.stroke();
                        ctx.restore();
                    }
                }
            }]
        });

        // Target Progress Chart
        const ctxTarget = document.getElementById('targetChart').getContext('2d');
        const achieved = 14580;
        const goal = 20000;

        new Chart(ctxTarget, {
            type: 'doughnut',
            data: {
                labels: ['Achieved', 'Remaining'],
                datasets: [{
                    data: [achieved, goal - achieved],
                    backgroundColor: ['#0d6efd', '#dee2e6'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false },
                    beforeDraw: (chart) => {
                        const { width, height, ctx } = chart;
                        ctx.restore();
                        const fontSize = (height / 160).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        const text = ((achieved / goal) * 100).toFixed(1) + "%";
                        const textX = Math.round((width - ctx.measureText(text).width) / 2);
                        const textY = height / 1.9;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }
            }
        });
    </script>

</body>

</html>