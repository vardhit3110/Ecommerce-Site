<?php require "slider.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .dashboard-container {
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .card-container {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }

        .dashboard-card1 {
            height: 130px;
            width: 300px;
            flex: 1;
            background-color: #d4edda;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card2 {
            height: 130px;
            width: 300px;
            flex: 1;
            background-color: #d1ecf1;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card3 {
            height: 130px;
            width: 300px;
            flex: 1;
            background-color: #f8d7da;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
                <div class="notification">
                    <i class="fas fa-bell"></i>
                    <div class="badge">3</div>
                </div>
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
        $tables = ["userdata"];
        foreach ($tables as $table) {
            $coun_query = "SELECT * FROM $table";
            $result = mysqli_query($conn, $coun_query);
            $row = mysqli_num_rows($result);
            $counts[$table] = $row;
        }
        ?>
        <!-- Content Area -->
        <div class="content-area">
            <div class="dynamic-content">
                <i class="fas fa-home"></i>
                <h2>Dashboard Overview</h2>

                <div class="card-container">
                    <div class="dashboard-card1">
                        <div class="text-dark">
                            <h3 style="font-weight: bold ;">Total Users </h3>
                            <h4><?php echo $counts["userdata"] = $row; ?></h4>
                        </div>
                    </div>
                    <div class="dashboard-card2">
                        <div class="text-dark">
                            <h3 style="font-weight: bold;">Name: Orders</h3>
                            <h4>Count: 0</h4>
                        </div>
                    </div>
                    <div class="dashboard-card3">
                        <div class="text-dark">
                            <h3 style="font-weight: bold;">Name: Reports</h3>
                            <h4>Count: 0</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2023 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>