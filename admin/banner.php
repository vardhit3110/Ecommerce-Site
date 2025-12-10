<?php
require "slider.php";
require "db_connect.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/banner.css">
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-gear"></i> Banner Manage</h1>
            <div class="user-profile">
                <i class="fa-solid fa-message-smile fa-2x"></i>&nbsp;
            </div>
        </div>

        <!-- main contact -->
        <div class="card shadow border-0 m-0">
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                    <h4 class="fw-bold mb-3 mb-md-0"><i class="bi bi-folder2-open"></i> All Banners</h4>
                    <div class="d-flex gap-2">
                        <a href="site_settings.php" class="btn btn-secondary">
                            <i class="fa fa-cogs" aria-hidden="true"></i> Site Settings
                        </a>

                        <a href="add_banner.php" class="btn btn-primary">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Sub Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM site_image ORDER BY id DESC";
                            $result = mysqli_query($conn, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $img = !empty($row['image_path']) ? $row['image_path'] : './images/banner/';
                                    $checked = ($row['status'] == 1) ? 'checked' : '';
                                    echo "<tr>
                                            <td><img src='./images/banner/{$img}' class='img-thumb'></td>
                                            <td>" . htmlspecialchars($row['title']) . "</td>
                                            <td>" . htmlspecialchars($row['sub_title']) . "</td>
                                            <td>
                                                <label class='switch'>
                                                <input type='checkbox' class='status-toggle' data-id='{$row['id']}' {$checked}>
                                                <span class='slider'></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a href='banner_edit.php?id={$row['id']}' class='btn btn-outline-primary btn-sm'>
                                                <i class='bi bi-pencil-square'></i> Edit
                                                </a>
                                                &nbsp;
                                                <a href='./partials/banner_delete.php?id={$row['id']}' class='btn btn-outline-danger btn-sm'
                                                onclick=\"return confirm('Are you sure you want to delete this content?');\">
                                                <i class='bi bi-trash'></i> Delete
                                                </a>
                                            </td>
                                            </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-danger'>No Content Found</td></tr>";
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
    <script>
        // Optional: AJAX for toggle update
        $(document).on('change', '.status-toggle', function () {
            var id = $(this).data('id');
            var status = this.checked ? 1 : 0;
            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: { id: id, status: status },
                success: function (response) {
                    console.log('Status updated for ID: ' + id);
                }
            });
        });
    </script>
</body>

</html>