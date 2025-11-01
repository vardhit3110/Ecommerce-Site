<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Performance Chart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background: #fff;
      font-family: "Poppins", sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .chart-container {
      width: 90%;
      max-width: 900px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    canvas {
      height: 400px !important;
    }
  </style>
</head>
<body>
  <div class="chart-container">
    <canvas id="orderChart"></canvas>
  </div>

  <script>
    const ctx = document.getElementById('orderChart').getContext('2d');

    const orderChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [
          'Jun 2025', 'Jul 2025', 'Aug 2025', 'Sep 2025', 'Oct 2025', 'Nov 2025',
          'Dec 2025', 'Jan 2026', 'Feb 2026', 'Mar 2026', 'Apr 2026'
        ],
        datasets: [{
          label: 'Order Performance',
          data: [31, 33, 34, 31, 30, 32, 34, 33, 35, 37, 39],
          borderColor: '#2563eb',
          backgroundColor: 'rgba(37, 99, 235, 0.2)',
          tension: 0.4,
          fill: true,
          pointRadius: 4,
          pointBackgroundColor: '#2563eb'
        }]
      },
      options: {
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: (context) => `Order Performance: ${context.parsed.y}`
            }
          }
        },
        scales: {
          y: {
            min: 28,
            max: 40,
            ticks: { stepSize: 2 },
            grid: { color: '#f3f3f3' }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
  </script>
</body>
</html>
