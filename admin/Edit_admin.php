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
    <title>Edit Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans&display=swap" rel="stylesheet">
    <?php include "links/icons.html"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="assets/Edit_admin.css">
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa fa-pen"></i> Edit Profile</h1>
        </div>

        <div class="container">
            <div class="card p-4">
                <form action="./partials/_adminprofile_update.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="<?php echo $fname; ?>"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo $lname; ?>"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>">
                        </div>
                        <!-- <div class="col-12 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" value="Arizona, United States">
                        </div> -->
                        <div class="col-12 mb-3">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control" name="bio" rows="3"><?php echo $bio; ?></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="adminProfile.php" class="btn btn-secondary px-4">Cancel</a>&nbsp;
                        <button type="submit" name="update" class="btn btn-success px-4"> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>