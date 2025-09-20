<?php
require "slider.php";
require "db_connect.php";

// Add this code at the top to handle the AJAX status update request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $user_id = intval($_POST['user_id']);
    $status = intval($_POST['status']);
    
    $stmt = mysqli_prepare($conn, "UPDATE userdata SET status = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $status, $user_id);
    $result = mysqli_stmt_execute($stmt);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update status']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... existing head content ... -->
    <style>
        /* ... existing styles ... */

        /* Updated Toggle Switch Styles */
        .status-toggle-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .status-indicator {
            display: inline-block;
            font-weight: 600;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .toggle-switch {
            position: relative;
            width: 40px;
            height: 20px;
            border-radius: 20px;
            background: #e5e5e5;
            cursor: pointer;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .toggle-slider {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            z-index: 2;
        }

        .toggle-text {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 4px;
            font-size: 8px;
            font-weight: bold;
        }

        .toggle-on {
            color: #2ecc71;
            opacity: 0;
        }

        .toggle-off {
            color: #e74c3c;
            opacity: 1;
        }

        .toggle-switch.active {
            background: rgba(46, 204, 113, 0.3);
        }

        .toggle-switch.active .toggle-slider {
            left: calc(100% - 18px);
            transform: rotate(360deg);
        }

        .toggle-switch.active .toggle-on {
            opacity: 1;
        }

        .toggle-switch.active .toggle-off {
            opacity: 0;
        }

        .toggle-switch.inactive {
            background: rgba(231, 76, 60, 0.3);
        }

        .toggle-switch.inactive .toggle-slider {
            left: 2px;
            transform: rotate(0);
        }

        .toggle-switch.inactive .toggle-on {
            opacity: 0;
        }

        .toggle-switch.inactive .toggle-off {
            opacity: 1;
        }

        .status-indicator.active {
            background: #2ecc71;
            color: white;
            box-shadow: 0 1px 3px rgba(46, 204, 113, 0.3);
        }

        .status-indicator.inactive {
            background: #e74c3c;
            color: white;
            box-shadow: 0 1px 3px rgba(231, 76, 60, 0.3);
        }
        
        /* Loading indicator */
        .status-updating {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <!-- ... existing header and container content ... -->
        
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

                            // Determine initial status based on database value
                            $status_class = ($row['status'] == 1) ? 'active' : 'inactive';
                            $status_text = ($row['status'] == 1) ? 'Active' : 'Inactive';
                            
                            echo '<td>
                            <div class="status-toggle-container">
                                <div class="status-indicator ' . $status_class . '" data-user-id="' . $row['id'] . '">' . $status_text . '</div>
                                <div class="toggle-switch ' . $status_class . '" data-user-id="' . $row['id'] . '" data-status="' . $row['status'] . '">
                                    <div class="toggle-slider"></div>
                                    <div class="toggle-text">
                                        <span class="toggle-on">On</span>
                                        <span class="toggle-off">Off</span>
                                    </div>
                                </div>
                            </div>
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

        <!-- ... existing pagination and footer ... -->
    </div>
    
    <!-- Add jQuery (required for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
</body>
</html>