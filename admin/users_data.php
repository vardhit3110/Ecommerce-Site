<?php
require "slider.php";
require "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_status') {
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

    if (isset($_POST['search'])) {
        $search = mysqli_real_escape_string($conn, $_POST['search']);
    }
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$total_data = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $total_data;

// Build query based on search
if (!empty($search)) {
    $search_term = "%$search%";
    $sql = "SELECT * FROM userdata 
            WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ? 
            LIMIT {$offset}, {$total_data}";
    $count_sql = "SELECT COUNT(*) AS total FROM userdata 
                  WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $search_term, $search_term, $search_term, $search_term);

    $count_stmt = mysqli_prepare($conn, $count_sql);
    mysqli_stmt_bind_param($count_stmt, "ssss", $search_term, $search_term, $search_term, $search_term);
} else {
    $sql = "SELECT * FROM userdata LIMIT {$offset}, {$total_data}";
    $count_sql = "SELECT COUNT(*) AS total FROM userdata";

    $stmt = mysqli_prepare($conn, $sql);
    $count_stmt = mysqli_prepare($conn, $count_sql);
}

// Execute queries
mysqli_stmt_execute($stmt);
$result_email = mysqli_stmt_get_result($stmt);

mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$count_row = mysqli_fetch_assoc($count_result);
$total_user = $count_row['total'];
$total_page = ceil($total_user / $total_data);

$start = ($page - 1) * $total_data + 1;
$end = min($page * $total_data, $total_user);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
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
            min-height: 740px;
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
            text-align: right;
            margin-bottom: 5px;
        }

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

        .status-updating {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Alert animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        .status-alert {
            animation: fadeIn 0.3s ease forwards;
        }

        .status-alert.fade-out {
            animation: fadeOut 0.3s ease forwards;
        }

        .search-loading {
            position: relative;
        }

        .search-loading::after {
            content: '';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: translateY(-50%) rotate(0deg);
            }

            100% {
                transform: translateY(-50%) rotate(360deg);
            }
        }

        .search-info {
            font-size: 12px;
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa fa-users" aria-hidden="true"></i> User Table</h1>
            <div class="user-profile">
                <i class="fa-duotone fa-regular fa-calendar-users fa-2x"></i>&nbsp;
            </div>
        </div>

        <div class="container p-4">
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
            <div class="row g-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="position-relative">
                            Search: <input type="text" id="searchInput"
                                class="form-control d-inline-block w-auto search-loading" placeholder="Searching..."
                                value="<?php echo htmlspecialchars($search); ?>">
                            <?php if (!empty($search)): ?>
                                <div class="search-info mt-1">Searching for: "<?php echo htmlspecialchars($search); ?>"
                                </div>
                            <?php endif; ?>
                        </div>
                        <a href="#" class="btn btn-primary"> <i class="fa-solid fa-plus"></i> Add New</a>
                    </div>

                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Users Data</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered border-dark text-center">
                                    <thead class="table-success table-bordered border-dark">
                                        <tr>
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
                                    <tbody id="userTableBody">
                                        <?php
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

                                                /* active inactive */
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
                                                    <a href='?id={$row['id']}" . (!empty($search) ? "&search=" . urlencode($search) : "") . "' class='btn btn-outline-primary btn-sm me-2'>Edit</a>
                                                    <a href='partials/_delete-user.php?id={$row['id']}' class='btn btn-outline-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
                                                </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center text-danger'>No records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <?php if ($total_user > 0): ?>
                                <div id="paginationSection">
                                    <ul class="pagination">
                                        <!-- Prev button -->
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">«
                                                    Prev</a>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item disabled"><a class="page-link" href="#">« Prev</a></li>
                                        <?php endif; ?>
                                        <?php
                                        $visiblePages = 1;
                                        $startPage = max(1, $page - $visiblePages);
                                        $endPage = min($total_page, $page + $visiblePages);

                                        if ($startPage > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">1</a>
                                            </li>
                                            <?php if ($startPage > 2): ?>
                                                <li class="page-item disabled"><a class="page-link">...</a></li>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <a class="page-link"
                                                    href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($endPage < $total_page): ?>
                                            <?php if ($endPage < $total_page - 1): ?>
                                                <li class="page-item disabled"><a class="page-link">...</a></li>
                                            <?php endif; ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?page=<?php echo $total_page; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"><?php echo $total_page; ?></a>
                                            </li>
                                        <?php endif; ?>

                                        <!-- Next button -->
                                        <?php if ($page < $total_page): ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?page=<?php echo $page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Next
                                                    »</a>
                                            </li>
                                        <?php else: ?>
                                            <li class="page-item disabled"><a class="page-link" href="#">Next »</a></li>
                                        <?php endif; ?>
                                    </ul>
                                    <div class='pagination-info'>Showing <?php echo $start; ?> to <?php echo $end; ?> of
                                        <?php echo $total_user; ?> entries
                                    </div>
                                    <?php if (!empty($search)): ?>
                                        <div class='pagination-info search-info'>Search results for:
                                            "<?php echo htmlspecialchars($search); ?>"</div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let searchTimeout;
            $('#searchInput').on('input', function () {
                const searchTerm = $(this).val();
                $('.search-loading').css('display', 'block');

                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(function () {
                    performSearch(searchTerm);
                }, 500);
            });

            function performSearch(searchTerm) {
                $.ajax({
                    url: 'users_data.php',
                    type: 'GET',
                    data: {
                        search: searchTerm,
                        page: 1
                    },
                    success: function (response) {
                        const tempDiv = $('<div>').html(response);
                        const newTableBody = tempDiv.find('#userTableBody').html();
                        const newPagination = tempDiv.find('#paginationSection').html();

                        $('#userTableBody').html(newTableBody);
                        $('#paginationSection').html(newPagination);

                        $('.search-loading').css('display', 'none');

                        // Update URL without reloading
                        const newUrl = new URL(window.location);
                        if (searchTerm) {
                            newUrl.searchParams.set('search', searchTerm);
                        } else {
                            newUrl.searchParams.delete('search');
                        }
                        newUrl.searchParams.set('page', '1');
                        window.history.replaceState({}, '', newUrl);

                        // Re-attach event listeners for toggle switches
                        attachToggleListeners();
                    },
                    error: function () {
                        $('.search-loading').css('display', 'none');
                        showAlert('Error: Could not perform search', 'error');
                    }
                });
            }

            function attachToggleListeners() {
                const toggleSwitches = document.querySelectorAll('.toggle-switch');

                toggleSwitches.forEach(toggle => {
                    // Remove existing event listeners
                    toggle.replaceWith(toggle.cloneNode(true));
                });

                // Re-select after clone
                const newToggleSwitches = document.querySelectorAll('.toggle-switch');

                newToggleSwitches.forEach(toggle => {
                    toggle.addEventListener('click', function () {
                        const statusIndicator = this.previousElementSibling;
                        const userId = this.getAttribute('data-user-id');
                        let currentStatus = parseInt(this.getAttribute('data-status'));
                        let newStatus = currentStatus === 1 ? 0 : 1;

                        this.classList.add('status-updating');
                        statusIndicator.classList.add('status-updating');

                        if (newStatus === 1) {
                            showAlert('User status set to Active', 'success');
                        } else {
                            showAlert('User status set to Inactive', 'warning');
                        }

                        // Update UI immediately
                        if (currentStatus === 1) {
                            this.classList.remove('active');
                            this.classList.add('inactive');
                            this.setAttribute('data-status', '0');
                            statusIndicator.textContent = 'Inactive';
                            statusIndicator.classList.remove('active');
                            statusIndicator.classList.add('inactive');
                        } else {
                            this.classList.remove('inactive');
                            this.classList.add('active');
                            this.setAttribute('data-status', '1');
                            statusIndicator.textContent = 'Active';
                            statusIndicator.classList.remove('inactive');
                            statusIndicator.classList.add('active');
                        }

                        // Send AJAX request
                        $.ajax({
                            url: '',
                            type: 'POST',
                            data: {
                                action: 'update_status',
                                user_id: userId,
                                status: newStatus
                            },
                            success: function (response) {
                                const result = JSON.parse(response);
                                if (!result.success) {
                                    // Revert UI changes if update failed
                                    if (newStatus === 1) {
                                        toggle.classList.remove('active');
                                        toggle.classList.add('inactive');
                                        toggle.setAttribute('data-status', '0');
                                        statusIndicator.textContent = 'Inactive';
                                        statusIndicator.classList.remove('active');
                                        statusIndicator.classList.add('inactive');
                                    } else {
                                        toggle.classList.remove('inactive');
                                        toggle.classList.add('active');
                                        toggle.setAttribute('data-status', '1');
                                        statusIndicator.textContent = 'Active';
                                        statusIndicator.classList.remove('inactive');
                                        statusIndicator.classList.add('active');
                                    }
                                    showAlert('Error: ' + result.message, 'error');
                                }

                                toggle.classList.remove('status-updating');
                                statusIndicator.classList.remove('status-updating');
                            },
                            error: function () {
                                // Revert UI changes on error
                                if (newStatus === 1) {
                                    toggle.classList.remove('active');
                                    toggle.classList.add('inactive');
                                    toggle.setAttribute('data-status', '0');
                                    statusIndicator.textContent = 'Inactive';
                                    statusIndicator.classList.remove('active');
                                    statusIndicator.classList.add('inactive');
                                } else {
                                    toggle.classList.remove('inactive');
                                    toggle.classList.add('active');
                                    toggle.setAttribute('data-status', '1');
                                    statusIndicator.textContent = 'Active';
                                    statusIndicator.classList.remove('inactive');
                                    statusIndicator.classList.add('active');
                                }

                                toggle.classList.remove('status-updating');
                                statusIndicator.classList.remove('status-updating');
                                showAlert('Error: Could not update status. Please try again.', 'error');
                            }
                        });
                    });
                });
            }

            attachToggleListeners();

            // Function to show alert messages
            function showAlert(message, type) {
                const existingAlert = document.querySelector('.status-alert');
                if (existingAlert) {
                    existingAlert.remove();
                }

                const alert = document.createElement('div');
                alert.className = `status-alert alert-${type}`;
                alert.textContent = message;

                alert.style.position = 'fixed';
                alert.style.top = '20px';
                alert.style.right = '20px';
                alert.style.padding = '10px 15px';
                alert.style.borderRadius = '4px';
                alert.style.fontSize = '14px';
                alert.style.fontWeight = '500';
                alert.style.zIndex = '10000';
                alert.style.boxShadow = '0 3px 10px rgba(0, 0, 0, 0.2)';
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';

                // Set background color based on type
                if (type === 'success') {
                    alert.style.backgroundColor = '#4CAF50';
                    alert.style.color = 'white';
                } else if (type === 'warning') {
                    alert.style.backgroundColor = '#FF9800';
                    alert.style.color = 'white';
                } else if (type === 'error') {
                    alert.style.backgroundColor = '#F44336';
                    alert.style.color = 'white';
                }

                document.body.appendChild(alert);

                setTimeout(() => {
                    alert.style.opacity = '1';
                }, 10);

                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 300);
                }, 3000);
            }

            $(document).on('click', '.pagination a', function (e) {
            });
        });
    </script>
</body>

</html>