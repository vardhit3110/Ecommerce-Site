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
                <style>
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    }

                    body {
                        background-color: #f5f5f5;
                        color: #333;
                        line-height: 1.6;
                    }

                    .container {
                        display: flex;
                        justify-content: center;
                        max-width: 1200px;
                        margin: 20px auto;
                        gap: 20px;
                    }

                    .notifications-content {
                        flex: 0 0 80%;
                        max-width: 800px;
                        background-color: white;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                        padding: 20px;
                    }

                    .notifications-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 20px;
                        padding-bottom: 15px;
                        border-bottom: 1px solid #eee;
                    }

                    .notifications-header h1 {
                        font-size: 1.5rem;
                        color: #333;
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }

                    .notifications-header i {
                        color: #4a6ee0;
                    }

                    .filter-options {
                        display: flex;
                        gap: 10px;
                        margin-bottom: 20px;
                    }

                    .filter-btn {
                        padding: 8px 15px;
                        background-color: #f1f1f1;
                        border: none;
                        border-radius: 4px;
                        cursor: pointer;
                        font-weight: 500;
                        transition: all 0.3s;
                    }

                    .filter-btn.active {
                        background-color: #4a6ee0;
                        color: white;
                    }

                    .notifications-list {
                        display: flex;
                        flex-direction: column;
                        gap: 20px;
                    }

                    .notification-item {
                        border: 1px solid #eee;
                        border-radius: 8px;
                        overflow: hidden;
                        background-color: white;
                        transition: transform 0.3s, box-shadow 0.3s;
                    }

                    .notification-item:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }

                    .notification-header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 15px;
                        background-color: #f9f9f9;
                        border-bottom: 1px solid #eee;
                    }

                    .user-info {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }

                    .user-avatar {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        background-color: #4a6ee0;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-weight: bold;
                    }

                    .user-details h3 {
                        font-size: 1rem;
                        margin-bottom: 2px;
                    }

                    .user-details .date {
                        font-size: 0.8rem;
                        color: #888;
                    }

                    .rating {
                        display: flex;
                        gap: 3px;
                    }

                    .star {
                        color: #ffc107;
                    }

                    .notification-body {
                        padding: 15px;
                    }

                    .user-comment {
                        padding: 10px 15px;
                        background-color: #f9f9f9;
                        border-radius: 8px;
                        margin-bottom: 15px;
                        position: relative;
                    }

                    .user-comment:before {
                        content: "";
                        position: absolute;
                        top: -8px;
                        left: 20px;
                        width: 0;
                        height: 0;
                        border-left: 8px solid transparent;
                        border-right: 8px solid transparent;
                        border-bottom: 8px solid #f9f9f9;
                    }

                    .admin-reply {
                        padding: 10px 15px;
                        background-color: #e8f4fd;
                        border-radius: 8px;
                        position: relative;
                        border-left: 3px solid #4a6ee0;
                    }

                    .admin-reply:before {
                        content: "Admin Reply";
                        position: absolute;
                        top: -10px;
                        left: 15px;
                        background-color: #4a6ee0;
                        color: white;
                        font-size: 0.7rem;
                        padding: 2px 8px;
                        border-radius: 4px;
                    }

                    .no-reply {
                        padding: 10px 15px;
                        background-color: #fff9e6;
                        border-radius: 8px;
                        text-align: center;
                        font-style: italic;
                        color: #888;
                    }

                    .empty-notifications {
                        text-align: center;
                        padding: 40px 20px;
                        color: #888;
                    }

                    .empty-notifications img {
                        max-width: 350px;
                        height: auto;
                        margin-bottom: 20px;
                        opacity: 0.7;
                    }

                    .empty-notifications p {
                        font-size: 1.2rem;
                        font-weight: 500;
                    }

                    .status-badge {
                        padding: 4px 8px;
                        border-radius: 4px;
                        font-size: 0.7rem;
                        font-weight: 600;
                    }

                    .status-replied {
                        background-color: #e8f5e9;
                        color: #2e7d32;
                    }

                    .status-pending {
                        background-color: #fff3e0;
                        color: #ef6c00;
                    }

                    @media (max-width: 768px) {
                        .container {
                            flex-direction: column;
                        }

                        .notifications-content {
                            flex: none;
                            width: 100%;
                        }

                        .notification-header {
                            flex-direction: column;
                            align-items: flex-start;
                            gap: 10px;
                        }

                        .filter-options {
                            flex-wrap: wrap;
                        }
                    }
                </style>
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