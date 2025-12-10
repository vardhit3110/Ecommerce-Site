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

if (!empty($search)) {
    $search_term = "%$search%";
    $sql = "SELECT * FROM userdata WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ? LIMIT {$offset}, {$total_data}";
    $count_sql = "SELECT COUNT(*) AS total FROM userdata WHERE username LIKE ? OR email LIKE ? OR phone LIKE ? OR city LIKE ?";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/users_data.css">
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa fa-users" aria-hidden="true"></i> Resigter User</h1>
            <div class="user-profile">
                <i class="fa-duotone fa-regular fa-calendar-users fa-2x"></i>&nbsp;
            </div>
        </div>

        <div class="card shadow border-0" id="card-body">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0"><i class="fa-solid fa-user-plus"></i> Users List</h4>
                    <div>
                        <input id="searchInput" type="text" class="form-control d-inline-block w-auto"
                            placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                        <a href="#" class="btn btn-primary ms-2"><i class="fa-solid fa-plus"></i> Add New</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center mt-0">
                        <thead class="table-primary">
                            <tr>
                                <th><input type="checkbox" class="checkbox-style" id="selectAll"></th>
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
                                    $email = $row['email'];
                                    // Image logic
                                    $image_path = "";
                                    if (!empty($row['image'])) {
                                        $image_path = "../store/images/user_img/" . htmlspecialchars($row['image']);
                                    } else {
                                        if ($row['gender'] == 1) {
                                            $image_path = "../store/images/user_img/male_default_img.png";
                                        } elseif ($row['gender'] == 2) {
                                            $image_path = "../store/images/user_img/female_default_img.png";
                                        } else {
                                            $image_path = "../store/images/user_img/default_img.jpeg";
                                        }
                                    }
                                    echo "<tr>";
                                    echo '<td><input type="checkbox" class="checkbox-style singleCheck"></td>';
                                    echo "<td><div class='user-info'><img src='{$image_path}' alt='User Image'><span>{$row['username']}</span></div></td>";
                                    echo "<td><p class='user-email'><i class='fa-regular fa-envelope'></i>&nbsp;{$email}<span class='tooltip-text'><i class='fa-regular fa-envelope'></i>&nbsp;{$email}</span></p></td>";
                                    echo "<td><div class='user-ph><div class='user-ph'><i class='fa-regular fa-phone'></i>&nbsp" . ($row['phone'] ?: 'N/A') . "</div></td>";
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
                                            <a href='user_edit.php?id={$row['id']}" . (!empty($search) ? "&search=" . urlencode($search) : "") . "' class='btn btn-sm btn-outline-primary me-2'><i class='bi bi-pencil-square'></i> Edit</a>
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
        <div class="footer">
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

        /* checkbox all check */
        $('#selectAll').on('change', function () {
            $('.singleCheck').prop('checked', $(this).prop('checked'));
        });

        $(document).on('change', '.singleCheck', function () {
            if (!$(this).prop('checked')) {
                $('#selectAll').prop('checked', false);
            } else if ($('.singleCheck:checked').length === $('.singleCheck').length) {
                $('#selectAll').prop('checked', true);
            }
        });
    </script>
</body>

</html>