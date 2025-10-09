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
        <div class="container p-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm border-1 h-100">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fa-solid fa-list"></i> Feedback</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table table-striped table-bordered border-dark table-hover align-middle mb-0">
                                    <thead class="">
                                        <tr class="table-success border-dark">
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

                                        $stmt = mysqli_prepare($conn, "SELECT userdata.username, userdata.email, feedback.* FROM userdata JOIN feedback ON userdata.id = feedback.user_id WHERE feedback.reply_comment IS NULL");

                                        if ($stmt) {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);
                                            if (mysqli_num_rows($result) > 0) {

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $feedback_id = $row['feedback_id'];
                                                    $user_id = $row['user_id'];
                                                    $rating = $row['rating'];
                                                    $comment = $row['comment'];
                                                    $submisiondate = $row['submision_date'];
                                                    $username = $row['username'];
                                                    $email = $row['email'];

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $feedback_id; ?></td>
                                                        <td><?php echo $username; ?></td>
                                                        <td><?php echo $email; ?></td>
                                                        <td><?php echo $rating; ?>/5</td>
                                                        <td title="<?php echo $comment; ?>">
                                                            <?php echo $comment; ?><br>
                                                            <span
                                                                style="font-size: 9px; display: flex; color: #dd0016ff;"><?php echo $submisiondate; ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#" class="btn btn-primary btn-sm"
                                                                onclick="openReplyModal(<?php echo $user_id; ?>, '<?php echo addslashes($username); ?>', '<?php echo addslashes($comment); ?>')">Reply</a>
                                                            &nbsp;&nbsp;
                                                            <a href="./partials/_feedbackManage.php?user_id=<?php echo $user_id; ?>"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirmDelete();">Delete</a>

                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='6' class='text-center text-danger'>No records found</td></tr>";
                                            }
                                            mysqli_stmt_close($stmt);
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center text-danger'>Query preparation failed</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reply Modal -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="replyForm" method="POST">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title" id="replyModalLabel">Send Reply to <span
                                    id="user_name_display"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="user_id" id="modal_user_id">
                            <div class="mb-3">
                                <label class="form-label"><strong>User's Comment:</strong></label>
                                <div class="alert alert-info p-2 mb-3" id="user_comment_display"></div>
                            </div>
                            <div class="mb-3">
                                <label for="reply_message" class="form-label">Your Reply Message</label>
                                <textarea class="form-control" name="reply_message" id="reply_message" rows="4"
                                    placeholder="Type your reply here..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="./partials/_feedbackReply.php?user_id=<?php echo ""; ?>" type="submit"
                                class="btn btn-success">Send Reply</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this feedback?");
        }

        function openReplyModal(userId, username, comment) {
            document.getElementById("modal_user_id").value = userId;
            document.getElementById("user_name_display").textContent = username;
            document.getElementById("user_comment_display").textContent = comment;

            var replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
            replyModal.show();
        }
    </script>
</body>

</html>
