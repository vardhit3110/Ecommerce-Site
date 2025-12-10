<?php
require "slider.php";
require "db_connect.php";

$total_data = 8;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $total_data;
$query = "SELECT c.id, c.user_id, u.username AS name, u.email AS user_email, c.subject, c.message, c.reply_status, c.email_send  FROM contactus c JOIN userdata u ON c.user_id = u.id ORDER BY c.id DESC LIMIT {$offset}, {$total_data}";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/user_contact.css">
</head>

<body>
    <div class="main-content">
        <div class="header mb-4">
            <h1><i class="fa-solid fa-envelope"></i> User Contact Messages</h1>
        </div>

        <div class="card shadow border-0">
            <div class="card-body">
                <h4 class="fw-bold mb-3"><i class="fa-solid fa-message"></i> Contact Us</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th><input type="checkbox" class="checkbox-style" id="selectAll"></th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Reply Status</th>
                                <th>Email Send</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $replyStatus = $row['reply_status'] == 1
                                        ? '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Replied</span>'
                                        : '<span class="badge text-warning" style="background-color: hsla(43, 100%, 95%, 1.00);">Pending</span>';

                                    $emailSend = $row['email_send'] == 1
                                        ? '<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Send</span>'
                                        : '<span class="badge text-secondary" style="background-color: hsla(0, 0%, 85%, 1.00);">Not Send</span>';

                                    echo "<tr id='row_{$row['id']}'>
                                        <td><input type='checkbox' class='checkbox-style singleCheck'></td></td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['user_email']}</td>
                                        <td>{$row['subject']}</td>
                                        <td title='{$row['message']}'>" . substr($row['message'], 0, 30) . "...</td>
                                        <td class='reply_status'>{$replyStatus}</td>
                                        <td class='email_send'>{$emailSend}</td>
                                        <td>
                                            <button class='btn btn-sm btn-outline-primary reply-btn'
                                                data-contact='{$row['id']}'
                                                data-user='{$row['user_id']}'
                                                data-name='{$row['name']}'
                                                data-email='{$row['user_email']}'>
                                                <i class='bi bi-reply'></i> Reply
                                            </button>
                                            <a href='./partials/contact-delete.php?id={$row['id']}' class='btn btn-sm btn-outline-danger' 
                                                onclick=\"return confirm('Are you sure you want to delete this message?');\">
                                                <i class='bi bi-trash'></i> Delete
                                            </a>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-danger'>No Contact Messages Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Pagination Section -->
                    <?php
                    $sql = "SELECT COUNT(*) AS total FROM contactus";
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
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">« Prev</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">« Prev</a></li>';
                        }

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
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next »</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><a class="page-link" href="#">Next »</a></li>';
                        }

                        echo '</ul>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="replyForm">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-reply-all"></i> Send Reply</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="user_email" id="modal_user_email_input">
                            <input type="hidden" name="contact_id" id="modal_contact_id">
                            <input type="hidden" name="user_id" id="modal_user_id">
                            <p><b>User Name:</b> <span id="modal_user_name"></span></p>
                            <p><b>Email:</b> <span id="modal_user_email"></span></p>
                            <label class="input-label">Reply Message</label>
                            <textarea name="reply_message" class="form-control" required
                                placeholder="Write your reply..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Send Reply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('.reply-btn').click(function () {
                    $('#modal_contact_id').val($(this).data('contact'));
                    $('#modal_user_id').val($(this).data('user'));
                    $('#modal_user_name').text($(this).data('name'));
                    $('#modal_user_email_input').val($(this).data('email'));
                    $('#modal_user_email').text($(this).data('email'));
                    $('#replyModal').modal('show');
                });

                // ajax
                $('#replyForm').submit(function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: 'reply_action.php',
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            alert(response.message);
                            if (response.status == 'success') {
                                var rowId = '#row_' + $('#modal_contact_id').val();
                                $(rowId + ' .reply_status').html('<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Replied</span>');
                                $(rowId + ' .email_send').html('<span class="badge text-success" style="background-color: hsla(152, 85%, 92%, 1.00);">Send</span>');
                                $('#replyModal').modal('hide');
                                $('#replyForm')[0].reset();
                            }
                        },
                        error: function () {
                            alert('Something went wrong!');
                        }
                    });
                });
            });
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
        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>