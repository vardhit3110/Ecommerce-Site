<?php
require "slider.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_status') {
    header('Content-Type: application/json');

    $catId = $_POST['id'];
    $status = $_POST['status'];
    if (!is_numeric($catId) || !is_numeric($status)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $stmt = mysqli_prepare($conn, "UPDATE categories SET categorie_status = ? WHERE categorie_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $status, $catId);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php include "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

        .error {
            color: red;
            font-size: 13px;
            margin-top: 3px;
        }

        .card-header {
            border-bottom: 1px solid #dee2e6;
        }

        .card {
            border-radius: 12px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn i {
            pointer-events: none;
        }

        .desc-size {
            max-width: 450px;
        }

        #box-color {
            background-color: #f8f8f8ff;
        }

        .card-body {
            border-radius: 15px;
            background-color: rgba(255, 249, 249, 1)
        }

        #card-body {
            border-radius: 15px;
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

        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        td img {
            height: 70px;
            width: 70px;
            border-radius: 20%;
            object-fit: cover;
            margin-right: 10px;
        }

        td .cat-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cat-details {
            font-size: 13px;
            line-height: 1.4;
            text-align: left;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>

</head>

<body>

    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-table-layout"></i> Category List</h1>
            <div class="user-profile">
                <i class="fa-solid fa-layer-group fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container  -->
        <div class="card shadow border-0" id="card-body">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0"><i class="fa-solid fa-list"></i> Categories</h4>
                    <a href="category-add.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add New</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center mt-0">
                        <thead class="table-success">
                            <tr>
                                <th><input type="checkbox" class="checkbox-style" id="selectAll"></th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = mysqli_prepare($conn, "SELECT * FROM categories");
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $catId = $row['categorie_id'];
                                    $status = $row['categorie_status'];
                                    $isActive = $status == 1;
                                    echo "<tr>";
                                    echo '<td><input type="checkbox" class="checkbox-style singleCheck"></td>';
                                    echo "<td><div class='cat-info'><img src='images/" . htmlspecialchars($row['categorie_image']) . "' alt='Category Image'><span>" . htmlspecialchars($row['categorie_name']) . "</span></div></td>";
                                    echo "<td class='cat-details'>" . htmlspecialchars($row['categorie_desc']) . "</td>";

                                    echo '<td>
                                        <div class="d-flex flex-column align-items-center">
                                            <div class="status-indicator ' . ($isActive ? 'active' : 'inactive') . '">' . ($isActive ? 'Active' : 'Inactive') . '</div>
                                            <div class="toggle-switch mt-2 ' . ($isActive ? 'active' : 'inactive') . '" onclick="toggleStatus(this,' . $catId . ',' . $status . ')">
                                                <div class="toggle-slider"></div>
                                            </div>
                                        </div>
                                    </td>';

                                    echo "<td>
                                        <a href='category-edit.php?id={$row['categorie_id']}' class='btn btn-sm btn-outline-primary me-2'><i class='bi bi-pencil-square'></i> Edit</a>
                                        <a href='partials/_categories_add.php?id={$row['categorie_id']}' class='btn btn-sm btn-outline-danger' onclick=\"return confirm('Are you sure you want to delete this record?')\"><i class='bi bi-trash'></i> Delete</a>
                                    </td>";

                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-danger'>No records found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleStatus(element, catId, currentStatus) {
            const newStatus = currentStatus == 1 ? 2 : 1;
            const willBeActive = newStatus == 1;

            element.classList.add('status-updating');

            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    action: 'update_status',
                    id: catId,
                    status: newStatus
                },
                success: function (response) {
                    element.classList.remove('status-updating');

                    if (response.success) {
                        if (willBeActive) {
                            element.classList.remove('inactive');
                            element.classList.add('active');
                            element.parentElement.querySelector('.status-indicator').textContent = 'ACTIVE';
                            element.parentElement.querySelector('.status-indicator').classList.remove('inactive');
                            element.parentElement.querySelector('.status-indicator').classList.add('active');
                        } else {
                            element.classList.remove('active');
                            element.classList.add('inactive');
                            element.parentElement.querySelector('.status-indicator').textContent = 'INACTIVE';
                            element.parentElement.querySelector('.status-indicator').classList.remove('active');
                            element.parentElement.querySelector('.status-indicator').classList.add('inactive');
                        }

                        alert('Category status updated successfully!');
                    } else {
                        if (confirm("Do you want to update the category status?")) {
                            window.location.href = "category_list.php";
                        }
                    }
                },
                error: function (xhr, status, error) {
                    element.classList.remove('status-updating');
                    alert('Error updating category status: ' + error);
                }
            });
        }
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