<?php
require "slider.php";
require "db_connect.php";

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM feedback WHERE user_id='$user_id'");
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user_feedback = $row['comment'];
            $rating = $row['rating'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
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

        .rating {
            display: flex;
            gap: 3px;
        }
        .star{
            color: #ffc107;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header p-3">
            <h1><i class="fa-solid fa-message-lines"></i> Reply to Feedback</h1>
        </div>

        <div class="container p-4">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-dark">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-reply"></i> Reply to Feedback</h5>
                        </div>
                        <div class="card-body bg-light">

                            <div class="mb-3">
                                <h5><label for="userId" class="form-label">User ID: <?php echo $user_id; ?></label></h5>

                                <div class="rating">
                                    <?php
                                    $totalStars = 5;
                                    for ($i = 1; $i <= $totalStars; $i++) {
                                        if ($i <= $rating) {
                                            echo '<span class="star"><i class="fa-solid fa-star"></i></span>';
                                        } else {
                                            echo '<span class="star"><i class="fa-regular fa-star"></i></span>';
                                        }
                                    }
                                    ?>
                                </div>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">User Feedback</label>
                                <div class="alert alert-info" role="alert">
                                    <?php echo $user_feedback; ?>
                                </div>
                            </div>

                            <form method="POST">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">

                                <div class="mb-3">
                                    <label for="replyMessage" class="form-label">Your Reply</label>
                                    <textarea class="form-control" id="replyMessage" name="replyMessage" rows="4"
                                        placeholder="Write your reply here..." required></textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="feedbackList.php" class="btn btn-secondary"><i
                                            class="fa-solid fa-xmark"></i> Close</a>
                                    <button type="submit" name="submitReply" class="btn btn-success">
                                        <i class="fa-solid fa-paper-plane"></i> Send Reply
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="footer text-center py-3">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
<?php
if (isset($_POST['submitReply'])) {
    $user_id = $_POST['user_id'];
    $replyMessage = $_POST['replyMessage'];

    $stmt = mysqli_prepare($conn, "UPDATE feedback SET reply_comment=? WHERE user_id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'si', $replyMessage, $user_id);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Feedback Reply Successful.!!');window.location.href='feedbackList.php?Status=Success   ';</script>";
            exit();
        } else {
            echo "<script>alert('Feedback Reply Faild!!');window.location.href='feedbackList.php?Status=Failed';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='feedbackList.php?Status=error';</script>";
    }
}
?>