<?php
require "slider.php";
require "db_connect.php";

$total_data = isset($_GET['entries']) ? (int) $_GET['entries'] : 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $total_data;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/subscribers-manage.css">
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-bell"></i> Subscribers Manage</h1>
            <div class="user-profile">
                <i class="fa-solid fa-message-smile fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <!-- <div class="container py-5"> -->
        <div class="card shadow border-0" id="card-body">
            <div class="card-body">
                <!-- Header Section -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-0">
                    <div class="d-flex align-items-center mb-3">
                        <label class="me-2">Show entries</label>
                        <select id="showEntries" class="form-select form-select-sm" style="width: 80px;">
                            <option value="10" <?php if ($total_data == 10)
                                echo 'selected'; ?>>10</option>
                            <option value="25" <?php if ($total_data == 25)
                                echo 'selected'; ?>>25</option>
                            <option value="50" <?php if ($total_data == 50)
                                echo 'selected'; ?>>50</option>
                            <option value="100" <?php if ($total_data == 100)
                                echo 'selected'; ?>>100</option>
                        </select>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Subscribed On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = mysqli_prepare($conn, "SELECT * FROM subscriber ORDER BY subscriber_id DESC LIMIT {$offset}, {$total_data}");

                            if ($stmt) {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td>{$row['subscriber_id']}</td>
                                                <td>{$row['subscriber_email']}</td>
                                                <td>{$row['subscriber_date']}</td>
                                                <td>
                                                    <a href='./partials/_subscriber-delete.php?subscriber_id={$row['subscriber_id']}' 
                                                       class='btn btn-sm btn-outline-danger' 
                                                       onclick=\"return confirm('Are you sure you want to delete this subscriber?');\">
                                                        <i class='bi bi-trash'></i> Delete
                                                    </a>
                                                </td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-danger'>No Subscribers Found</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<tr><td colspan='4' class='text-danger'>Query preparation failed</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <?php
                $sql = "SELECT COUNT(*) AS total FROM subscriber";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $total_user = $row['total'];
                $total_page = ceil($total_user / $total_data);

                $start = ($page - 1) * $total_data + 1;
                $end = min($page * $total_data, $total_user);

                if ($total_user > 0) {
                    echo '<div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">';
                    echo "<div class='pagination-info mb-0'>Showing $start to $end of $total_user entries</div>";
                    echo '<ul class="pagination mb-0">';

                    // Prev button
                    if ($page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '&entries=' . $total_data . '">« Prev</a></li>';
                    } else {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">« Prev</a></li>';
                    }

                    // Dynamic pages with ellipses
                    $visiblePages = 1;
                    $startPage = max(1, $page - $visiblePages);
                    $endPage = min($total_page, $page + $visiblePages);

                    if ($startPage > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                        if ($startPage > 2)
                            echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                    }

                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $active = ($i == $page) ? 'active' : '';
                        echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    }

                    if ($endPage < $total_page) {
                        if ($endPage < $total_page - 1)
                            echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                        echo '<li class="page-item"><a class="page-link" href="?page=' . $total_page . '">' . $total_page . '</a></li>';
                    }

                    // Next button
                    if ($page < $total_page) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '&entries=' . $total_data . '">Next »</a></li>';
                    } else {
                        echo '<li class="page-item disabled"><a class="page-link" href="#">Next »</a></li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <!-- </div> -->

        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
    <script>
        $('#showEntries').on('change', function () {
            var entries = $(this).val();
            window.location.href = "?entries=" + entries;
        });

        function confirmDelete() {
            return confirm("Are you sure you want to delete this feedback?");
        }
    </script>
</body>

</html>