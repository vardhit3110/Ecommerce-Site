<?php
require "slider.php";
include "db_connect.php";


$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $fname = $row['fname'];
    $lname = $row['lname'];
    $email = $row['email'];
    $phone = $row['phone'];
    $bio = $row['bio'];
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
    <?php include "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="assets/adminProfile.css">
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa fa-user-secret" aria-hidden="true"></i> Admin Profile</h1>
            <div class="user-profile">
                <i class="fa-solid fa-layer-group fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <div class="content-area container-fluid py-4">
            <div class="row g-4">
                <div class="container my-4">
                    <div class="card shadow-sm p-4 mb-4 rounded-4 border-0">
                        <h5 class="text-success fw-bold mb-3">Profile</h5>
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <div class="d-flex align-items-center">
                                <img src="../store/images/owner.jpeg" alt="Profile" class="rounded-circle me-3"
                                    width="80" height="80">
                                <div>
                                    <h5 class="fw-bold mb-1"><?php echo $lname . " " . $fname; ?></h5>
                                    <p class="text-muted mb-0">@<?php echo substr($email, 0, strpos($email, "@")); ?> |
                                        <span><?php echo $bio; ?></span>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 mt-md-0">
                                <a href="Edit_admin.php" class="btn btn-outline-primary ms-3 px-3" id="btn">
                                    <i class="fa fa-pen"></i> Edit
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm p-4 rounded-4 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-primary">Personal Information</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">First Name</small>
                                <p class="fw-semibold"><?php echo $fname; ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Last Name</small>
                                <p class="fw-semibold"><?php echo $lname; ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Email address</small>
                                <p class="fw-semibold"><?php echo $email; ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted d-block">Phone</small>
                                <p class="fw-semibold">+91 <?php echo $phone; ?></p>
                            </div>
                            <div class="col-12">
                                <small class="text-muted d-block">Bio</small>
                                <p class="fw-semibold"><?php echo $bio; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>