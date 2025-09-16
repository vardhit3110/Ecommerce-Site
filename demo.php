<?php 
require "slider.php"; 
require "db.php"; // Ensure DB connection is included

// Update logic (after form submit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];

    $update_query = "UPDATE userdata SET username=?, email=?, phone=?, city=?, gender=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, 'sssssi', $username, $email, $phone, $city, $gender, $id);
    mysqli_stmt_execute($stmt);

    // Redirect to avoid form resubmission
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}
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
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $edit_id = $_GET['id'];
            $edit_query = "SELECT * FROM userdata WHERE id=?";
            $stmt = mysqli_prepare($conn, $edit_query);
            mysqli_stmt_bind_param($stmt, 'i', $edit_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
        ?>
                <h4>Edit User</h4>
                <form method="POST" class="mb-4">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="username" class="form-control" placeholder="Username" value="<?= htmlspecialchars($row['username']) ?>" required>
                        </div>
                        <div class="col">
                            <input type="email" name="email" class="form-control" placeholder="Email" value="<?= htmlspecialchars($row['email']) ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="phone" class="form-control" placeholder="Phone" value="<?= htmlspecialchars($row['phone']) ?>">
                        </div>
                        <div class="col">
                            <input type="text" name="city" class="form-control" placeholder="City" value="<?= htmlspecialchars($row['city']) ?>">
                        </div>
                        <div class="col">
                            <select name="gender" class="form-control" required>
                                <option value="Male" <?= $row['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $row['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= $row['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
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
            <table class="table table-hover table-bordered border-dark">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Gender</th>
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
                            echo "<td>" . ($row['gender'] ?: 'N/A') . "</td>";
                            echo "<td>
                                    <a href='?id={$row['id']}' class='btn btn-primary btn-sm me-2'>Edit</a>
                                    <a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
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
        $sql = "SELECT COUNT(*) AS total FROM userdata";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $total_user = $row['total'];
        $total_page = ceil($total_user / $total_data);

        echo '<ul class="pagination">';
        echo '<li class="page-item ' . ($page <= 1 ? 'disabled' : '') . '"><a class="page-link" href="?page=' . max(1, $page - 1) . '">« Prev</a></li>';
        for ($i = 1; $i <= $total_page; $i++) {
            $active = ($i == $page) ? 'active' : '';
            echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
        }
        echo '<li class="page-item ' . ($page >= $total_page ? 'disabled' : '') . '"><a class="page-link" href="?page=' . min($total_page, $page + 1) . '">Next »</a></li>';
        echo '</ul>';
        ?>
    </div>

    <br>
    <div class="footer">
        <p>&copy; 2023 Admin Panel. All rights reserved.</p>
    </div>
</div>
</body>
</html>
