<?php

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

$total_data = 8;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $total_data;

if (!empty($search)) {
    $search_term = "%$search%";
    $sql = "SELECT * FROM userdata WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ? LIMIT {$offset}, {$total_data}";
    $count_sql = "SELECT COUNT(*) AS total FROM userdata WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $search_term, $search_term, $search_term, $search_term);

    $count_stmt = mysqli_prepare($conn, $count_sql);
    mysqli_stmt_bind_param($count_stmt, "ssss", $search_term, $search_term, $search_term, $search_term);
} else {
    $sql = "SELECT * FROM userdata ORDER BY id DESC LIMIT {$offset}, {$total_data}";
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
    <title>Admin - Users Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --light: #f8f9fa;
            --dark: #212529;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-content .header h1 {
            font-size: 1.6rem;
            margin-bottom: 0.75rem;
        }

        .card#card-body {
            border-radius: 20px;
            overflow: hidden;
            max-width: 100%;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            min-width: 700px;
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
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .status-indicator {
            display: inline-block;
            font-weight: 600;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .status-indicator.active {
            background: #2ecc71;
            color: white;
        }

        .status-indicator.inactive {
            background: #e74c3c;
            color: white;
        }

        .toggle-switch {
            position: relative;
            width: 44px;
            height: 22px;
            border-radius: 22px;
            background: #e5e5e5;
            cursor: pointer;
        }

        .toggle-slider {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: white;
            transition: left 0.2s;
        }

        .toggle-switch.active {
            background: rgba(46, 204, 113, 0.25);
        }

        .toggle-switch.active .toggle-slider {
            left: calc(100% - 19px);
        }

        @media (max-width: 768px) {

            .table th,
            .table td {
                font-size: 13px;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
    <div class="main-content p-4">
        <div class="header mb-3 d-flex justify-content-between align-items-center">
            <h1><i class="fa-solid fa-users"></i> Users Data</h1>
            <div class="user-profile"><i class="fa-solid fa-user-circle fa-2x"></i></div>
        </div>

        <div class="card shadow border-0" id="card-body">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0"><i class="fa-solid fa-list"></i> Users</h4>
                    <div>
                        <input id="searchInput" type="text" class="form-control d-inline-block w-auto"
                            placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                        <a href="#" class="btn btn-primary ms-2"><i class="fa-solid fa-plus"></i> Add New</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
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

                                    $status_class = ($row['status'] == 1) ? 'active' : 'inactive';
                                    $status_text = ($row['status'] == 1) ? 'Active' : 'Inactive';

                                    echo '<td>
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="status-indicator ' . $status_class . '" data-user-id="' . $row['id'] . '">' . $status_text . '</div>
                                                <div class="toggle-switch mt-2 ' . $status_class . '" data-user-id="' . $row['id'] . '" data-status="' . $row['status'] . '">
                                                    <div class="toggle-slider"></div>
                                                </div>
                                            </div>
                                        </td>';

                                    echo "<td>
                                            <a href='?id={$row['id']}" . (!empty($search) ? "&search=" . urlencode($search) : "") . "' class='btn btn-sm btn-outline-primary me-2'><i class='bi bi-pencil-square'></i> Edit</a>
                                            <a href='partials/_delete-user.php?id={$row['id']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Are you sure you want to delete this record?')\"><i class='bi bi-trash'></i> Delete</a>
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
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class='pagination-info'>Showing <?php echo $start; ?> to <?php echo $end; ?> of
                            <?php echo $total_user; ?> entries
                        </div>
                        <ul class="pagination mb-0">
                            <?php if ($page > 1): ?>
                                <li class="page-item"><a class="page-link"
                                        href="?page=<?php echo $page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">«
                                        Prev</a></li>
                            <?php else: ?>
                                <li class="page-item disabled"><a class="page-link" href="#">« Prev</a></li>
                            <?php endif; ?>

                            <?php
                            $visiblePages = 1;
                            $startPage = max(1, $page - $visiblePages);
                            $endPage = min($total_page, $page + $visiblePages);

                            if ($startPage > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1' . (!empty($search) ? '&search=' . urlencode($search) : '') . '">1</a></li>';
                                if ($startPage > 2)
                                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                            }

                            for ($i = $startPage; $i <= $endPage; $i++) {
                                $active = ($i == $page) ? 'active' : '';
                                echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $i . (!empty($search) ? '&search=' . urlencode($search) : '') . '">' . $i . '</a></li>';
                            }

                            if ($endPage < $total_page) {
                                if ($endPage < $total_page - 1)
                                    echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $total_page . (!empty($search) ? '&search=' . urlencode($search) : '') . '">' . $total_page . '</a></li>';
                            }

                            if ($page < $total_page) {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . (!empty($search) ? '&search=' . urlencode($search) : '') . '">Next »</a></li>';
                            } else {
                                echo '<li class="page-item disabled"><a class="page-link" href="#">Next »</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <br>
        <div class="footer text-center mt-3">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let searchTimeout;
            $('#searchInput').on('input', function () {
                const searchTerm = $(this).val();
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(function () {
                    performSearch(searchTerm);
                }, 400);
            });

            function performSearch(searchTerm) {
                $.ajax({
                    url: 'users_data.php',
                    type: 'GET',
                    data: { search: searchTerm, page: 1 },
                    success: function (response) {
                        const tempDiv = $('<div>').html(response);
                        const newTableBody = tempDiv.find('#userTableBody').html();
                        const newPagination = tempDiv.find('.pagination').parent().html();

                        $('#userTableBody').html(newTableBody);
                        // replace pagination container
                        $('ul.pagination').parent().html(newPagination);

                        // Update URL
                        const newUrl = new URL(window.location);
                        if (searchTerm) newUrl.searchParams.set('search', searchTerm);
                        else newUrl.searchParams.delete('search');
                        newUrl.searchParams.set('page', '1');
                        window.history.replaceState({}, '', newUrl);

                        attachToggleListeners();
                    },
                    error: function () {
                        alert('Error: Could not perform search');
                    }
                });
            }

            function attachToggleListeners() {
                const toggles = document.querySelectorAll('.toggle-switch');

                toggles.forEach(toggle => {
                    toggle.replaceWith(toggle.cloneNode(true));
                });

                const newToggles = document.querySelectorAll('.toggle-switch');

                newToggles.forEach(toggle => {
                    toggle.addEventListener('click', function () {
                        const userId = this.getAttribute('data-user-id');
                        let currentStatus = parseInt(this.getAttribute('data-status'));
                        let newStatus = currentStatus === 1 ? 0 : 1;

                        const statusIndicator = this.previousElementSibling;

                        // optimistic UI
                        if (newStatus === 1) {
                            this.classList.remove('inactive'); this.classList.add('active');
                            statusIndicator.textContent = 'Active'; statusIndicator.classList.remove('inactive'); statusIndicator.classList.add('active');
                        } else {
                            this.classList.remove('active'); this.classList.add('inactive');
                            statusIndicator.textContent = 'Inactive'; statusIndicator.classList.remove('active'); statusIndicator.classList.add('inactive');
                        }

                        // send update
                        $.post('', { action: 'update_status', user_id: userId, status: newStatus }, function (res) {
                            try {
                                const result = JSON.parse(res);
                                if (!result.success) {
                                    alert('Error: ' + result.message);
                                    // revert UI
                                    if (newStatus === 1) {
                                        toggle.classList.remove('active'); toggle.classList.add('inactive');
                                        statusIndicator.textContent = 'Inactive';
                                    } else {
                                        toggle.classList.remove('inactive'); toggle.classList.add('active');
                                        statusIndicator.textContent = 'Active';
                                    }
                                } else {
                                    toggle.setAttribute('data-status', newStatus);
                                }
                            } catch (e) {
                                alert('Unexpected response from server');
                            }
                        }).fail(function () {
                            alert('Network error: Could not update status');
                        });
                    });
                });
            }

            attachToggleListeners();
        });
    </script>
</body>

</html>