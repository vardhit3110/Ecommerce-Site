<?php
session_start();
require "db_connect.php";

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in to submit feedback.'); window.location.href='index.php';</script>";
    exit();
}
$email = $_SESSION['email'];

$stmt = mysqli_prepare($conn, "SELECT * FROM userdata WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$userResult = mysqli_stmt_get_result($stmt);
$userRow = mysqli_fetch_assoc($userResult);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
    <?php require_once "links/icons.html"; ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .feedback-container,
        .feedback-display {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .star-rating {
            display: flex;
            justify-content: center;
            direction: rtl;
            font-size: 2rem;
            margin-bottom: 15px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: gold;
            transform: scale(1.1);
        }

        .feedback-card {
            background: #f9fafc;
            border-left: 5px solid #2c3e50;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .feedback-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .feedback-card h5 {
            color: #ffcc00;
            font-size: 1rem;
            margin-bottom: 6px;
        }

        /* thank you animation container */
        .thankyou-container {
            display: none;
            text-align: center;
            padding: 40px 20px;
        }

        .thankyou-container.active {
            display: block;
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* feedback display scrolling */
        .feedback-display {
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #ccc #f9f9f9;
        }

        .feedback-display::-webkit-scrollbar {
            width: 6px;
        }

        .feedback-display::-webkit-scrollbar-thumb {
            background-color: #bfbfbf;
            border-radius: 6px;
        }

        .feedback-display::-webkit-scrollbar-thumb:hover {
            background-color: #999;
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>

    <div class="container my-5">
        <div class="row">
            <!-- Feedback Form -->
            <div class="col-md-6">
                <div class="feedback-container" id="feedbackForm">
                    <h2 class="text-center mb-4">Submit Your Feedback</h2>
                    <form action="partials/_handleFeedback.php" method="POST">
                        <div class="form-group">
                            <label for="email"><b>Email:</b></label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo $email; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="rating"><b>Rating (Click a Star)</b></label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" required><label
                                    for="star5">&#9733;</label>
                                <input type="radio" id="star4" name="rating" value="4"><label
                                    for="star4">&#9733;</label>
                                <input type="radio" id="star3" name="rating" value="3"><label
                                    for="star3">&#9733;</label>
                                <input type="radio" id="star2" name="rating" value="2"><label
                                    for="star2">&#9733;</label>
                                <input type="radio" id="star1" name="rating" value="1"><label
                                    for="star1">&#9733;</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comment"><b>Your Feedback</b></label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" maxlength="255"
                                required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Submit Feedback</button>
                    </form>
                </div>

                <!-- Thank You Animation -->
                <div class="thankyou-container" id="thankyouContainer">
                    <h3>🎉 Thank You for Your Feedback!</h3>
                    <p>Your response has been recorded successfully.</p>
                    <button class="btn btn-success" id="goBackBtn">Give Another Feedback</button>
                </div>
            </div>

            <!-- Feedback Display Section -->
            <div class="col-md-6">
                <div class="feedback-display">
                    <h2 class="text-center mb-4">Recent Feedback</h2>
                    <?php
                    $sql = "SELECT f.*, u.email FROM feedback f JOIN userdata u ON f.user_id = u.id ORDER BY f.submision_date DESC LIMIT 10";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="feedback-card">
                                    <p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>
                                    <h5>Rating: ' . str_repeat('⭐', (int) $row['rating']) . '</h5>
                                    <p>"' . htmlspecialchars($row['comment']) . '"</p>
                                    <small class="text-muted">Posted on ' . $row['submision_date'] . '</small>
                                  </div>';
                        }
                    } else {
                        echo '<br><div class="text-center text-muted">
                        <img src="./store/images/sad-face.png" height="100px"><br>
                        <p class="text-danger">No feedback available yet.</p></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('form').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function (response) {
                    $("#feedbackForm").fadeOut(400, function () {
                        $("#thankyouContainer").addClass('active');
                    });
                },
                error: function () {
                    alert("Error submitting feedback. Please try again.");
                }
            });
        });

        $("#goBackBtn").click(function () {
            $("#thankyouContainer").removeClass('active').hide();
            $("#feedbackForm").fadeIn(400);
        });
    </script>
</body>

</html>