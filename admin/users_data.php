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
    <style>
        .container {
            background-color: white;
            border-radius: 20px;
        }

        .pagination {
            display: flex;
            list-style: none;
            justify-content: center;
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
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa fa-users" aria-hidden="true"></i> User Table</h1>
        </div>

        <div class="container p-4">
            <!-- Edit Form If ID is set -->
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $stmt = mysqli_prepare($conn, "SELECT * FROM userdata WHERE id= ?");
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <h4>Edit User</h4>
                    <form action="partials/_edit-user.php" method="POST" class="mb-4">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="username" class="form-control" placeholder="Username"
                                    value="<?php echo htmlspecialchars($row['username']); ?>" required>
                            </div>
                            <div class="col">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="<?php echo htmlspecialchars($row['email']); ?>" disabled required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="phone" class="form-control" placeholder="Phone"
                                    value="<?php echo htmlspecialchars($row['phone']); ?>">
                            </div>
                            <div class="col">
                                <input type="text" name="city" class="form-control" placeholder="City"
                                    value="<?php echo htmlspecialchars($row['city']); ?>">
                            </div>
                            <div class="col">
                                <select name="gender" class="form-control" required>
                                    <option value="1" <?php echo htmlspecialchars($row['gender'] == '1' ? 'selected' : '') ?>>Male
                                    </option>
                                    <option value="2" <?php echo htmlspecialchars($row['gender'] == '2' ? 'selected' : '') ?>>
                                        Female</option>
                                    <option value="" <?php echo htmlspecialchars($row['gender'] == '' ? 'selected' : '') ?>>
                                        Please Select Gender</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="update" class="btn btn-success">Update</button>
                        <a href="?" class="btn btn-secondary">Cancel</a>
                    </form>
                    <?php
                }
            }
            ?>

            <!-- User Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered border-dark text-center">
                    <thead class="table-dark">
                        <tr class="border-warning">
                            <th>Id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_data = 5;
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
                        $offset = ($page - 1) * $total_data;

                        $sql = "SELECT * FROM userdata LIMIT {$offset}, {$total_data}";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_execute($stmt);
                        $result_email = mysqli_stmt_get_result($stmt);

                        if (mysqli_num_rows($result_email) > 0) {
                            while ($row = mysqli_fetch_assoc($result_email)) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['username']}</td>";
                                echo "<td>{$row['email']}</td>";
                                echo "<td>" . ($row['phone'] ?: 'N/A') . "</td>";
                                echo "<td>" . ($row['city'] ?: 'N/A') . "</td>";
                                if ($row['gender'] == 1) {
                                    $gender = "Male";
                                } elseif ($row['gender'] == 2) {
                                    $gender = "Female";
                                } else {
                                    $gender = "N/A";
                                }
                                echo "<td>" . $gender . "</td>";

                                if ($row['status'] == 1) {
                                    $status = "Active";
                                } else {
                                    $status = "Inactive";
                                }
                                echo '<td><form method="post">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" role="switch" id="switchCheckChecked" checked>
                                </div></form>
                                        </td>';

                                echo "<td>
                                    <a href='?id={$row['id']}' class='btn btn-primary btn-sm me-2'>Edit</a>
                                    <a href='partials/_delete-user.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
                                  </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php
            $sql = "SELECT * FROM userdata";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {

                $total_user = mysqli_num_rows($result);
                $total_page = ceil($total_user / $total_data);

                echo '<ul class="pagination">';
                if ($page <= 1) {
                    echo '<li class="page-item disabled"><a class="page-link" href="?page=' . ($page - 1) . '">« Prev</a></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">« Prev</a></li>';
                }
                for ($i = 1; $i <= $total_page; $i++) {
                    if ($i == $page) {
                        $active = "active";
                    } else {
                        $active = "";
                    }
                    echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                }
                if ($total_page <= $page) {
                    echo '<li class="page-item disabled"><a class="page-link" href="?page=' . ($page + 1) . '">Next »</a></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next »</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>

        <br>
        <div class="footer">
            <p>&copy; 2023 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>