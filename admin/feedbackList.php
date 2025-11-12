<?php
require "slider.php";
require "db_connect.php";

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

        .container {
            background-color: white;
            border-radius: 20px;
            max-width: 100%;
            overflow-x: auto;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 600px;

        }

        .date {
            color: #757575ff;
            font-size: 12px;
        }

        td {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pagination {
            display: flex;
            list-style: none;
            justify-content: flex-end;
            padding-left: 0;
        }

        .page-item {
            margin: 0 4px;
        }

        .page-link {
            display: block;
            padding: 8px 12px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
            cursor: default;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            cursor: default;
        }

        .page-link:hover {
            background-color: #e9ecef;
        }

        .disabled:hover {
            cursor: not-allowed;
        }

        .pagination-info {
            font-size: 14px;
            color: #333;
        }

        @media (max-width: 768px) {
            .desc-size {
                max-width: 100% !important;
            }

            .card-body {
                padding: 10px;
            }

            .table th,
            .table td {
                font-size: 14px;
                white-space: nowrap;
            }
        }

        #card-box {
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header"> 
            <h1><i class="fa-solid fa-message-lines"></i> Feedback</h1>
            <div class="user-profile">
                <i class="fa-solid fa-message-smile fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <!-- <div class="container py-5"> -->
        <div class="card shadow border-0" id="card-box">
            <div class="card-body">
                <!-- Header Section -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                    <h4 class="fw-bold mb-3 mb-md-0">
                        <i class="fa-solid fa-users"></i> User Feedback
                    </h4>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_data = 7;
                            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
                            $offset = ($page - 1) * $total_data;

                            $query = "SELECT userdata.username, userdata.email, feedback.* FROM userdata JOIN feedback ON userdata.id = feedback.user_id WHERE feedback.reply_comment IS NULL ORDER BY feedback.feedback_id DESC LIMIT ?, ?";
                            $stmt = mysqli_prepare($conn, $query);
                            mysqli_stmt_bind_param($stmt, "ii", $offset, $total_data);

                            if ($stmt && mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $feedback_id = $row['feedback_id'];
                                        $user_id = $row['user_id'];
                                        $rating = $row['rating'];
                                        $comment = $row['comment'];
                                        $submission_date = $row['submision_date'];
                                        $username = $row['username'];
                                        $email = $row['email'];
                                        ?>
                                        <tr>
                                            <td><?php echo $feedback_id; ?></td>
                                            <td><?php echo htmlspecialchars($username); ?></td>
                                            <td><?php echo htmlspecialchars($email); ?></td>
                                            <td><?php echo $rating; ?>/5</td>
                                            <td title="<?php echo htmlspecialchars($comment); ?>">
                                                <?php echo htmlspecialchars($comment); ?><br>
                                                <span
                                                    style="font-size: 9px; color: #dd0016ff;"><?php echo $submission_date; ?></span>
                                            </td>
                                            <td class="text-center">
                                                <a href="feedbackReply.php?user_id=<?php echo $user_id; ?>"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-pen"></i> Reply
                                                </a>
                                                &nbsp;&nbsp;
                                                <a href="./partials/_feedbackManage.php?user_id=<?php echo $user_id; ?>"
                                                    class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this feedback?');">
                                                    <i class='bi bi-trash'></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-danger'>No Subscribers Found</td></tr>";
                                }
                                mysqli_stmt_close($stmt);
                            } else {
                                echo "<tr><td colspan='6' class='text-danger'>Query preparation failed</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <?php
                $sql = "SELECT COUNT(*) AS total FROM feedback WHERE reply_comment IS NULL";
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
                    echo '<li class="page-item ' . ($page <= 1 ? 'disabled' : '') . '">
                                <a class="page-link" href="?page=' . max(1, $page - 1) . '">« Prev</a>
                              </li>';

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

                    echo '<li class="page-item ' . ($page >= $total_page ? 'disabled' : '') . '">
                                <a class="page-link" href="?page=' . min($total_page, $page + 1) . '">Next »</a>
                              </li>';

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
        function confirmDelete() {
            return confirm("Are you sure you want to delete this feedback?");
        }
    </script>
</body>

</html>