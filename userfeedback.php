<?php
require "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in to view your notification.'); window.location.href='index.php';</script>";
    exit();
}
$username = $_SESSION['username'];
$stmt = mysqli_prepare($conn, "SELECT userdata.username, userdata.email, feedback.* FROM userdata JOIN feedback ON userdata.id = feedback.user_id WHERE userdata.username = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $email = $row['email'];
            $rating = $row['rating'];
            $comment = $row['comment'];
            $submission_date = $row['submision_date'];
            $reply_comment = $row['reply_comment'];
            ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>My Feedback</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                <link rel="stylesheet" href="assets/userfeedback.css">
            </head>

            <body>
                <?php include "header.php"; ?>
                <br><br>
                <div class="container">
                    <div class="notifications-content">
                        <div class="notifications-header">
                            <h1><i class="fa-solid fa-comments"></i> My Feedback</h1>
                        </div>
                        <div class="notifications-list">
                            <!-- Feedback Item 1 - Username --> <br>
                            <div class="notification-item" data-status="replied">
                                <div class="notification-header">
                                    <div class="user-info">
                                        <div class="user-avatar"><?php echo substr($username, 0, 1); ?></div>
                                        <div class="user-details">
                                            <h3><?php echo $username; ?></h3>
                                            <div class="date"><?php echo $submission_date; ?></div>
                                        </div>
                                    </div>
                                    <div class="rating">
                                        <?php
                                        $totalStars = 5;
                                        for ($i = 1; $i <= $totalStars; $i++) {
                                            if ($i <= $rating) {
                                                echo '<span class="star"><i class="fas fa-star"></i></span>';
                                            } else {
                                                echo '<span class="star"><i class="far fa-star"></i></span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
                                    if (empty($reply_comment)) {
                                        echo '<span class="status-badge status-pending">Pending</span>';
                                    } else {
                                        echo '<span class="status-badge status-replied">Replied</span>';
                                    }
                                    ?>
                                </div>
                                <div class="notification-body">
                                    <div class="user-comment">
                                        <?php echo $comment; ?>
                                    </div>
                                    <div class="admin-reply">
                                        <?php
                                        if (empty($reply_comment)) {
                                            echo "Soon..!!!";
                                        } else {
                                            echo $reply_comment;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <?php
        }
    } else {
        echo "<script>alert('You have not given any feedback yet.');window.history.back();</script>";
    }
} else {
    echo "Failed to prepare statement: " . mysqli_error($conn);
}
?>
        </div>
    </div>
    <br><br>
    <?php include "footer.php"; ?>
</body>

</html>