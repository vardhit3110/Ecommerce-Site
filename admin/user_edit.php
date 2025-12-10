<?php
require "slider.php";
require "db_connect.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid User ID!'); window.location.href='users_data.php';</script>";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM userdata WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('User not found!'); window.location.href='users_data.php';</script>";
    exit;
}

$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    // $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $status = (int) $_POST['status'];

    $update = "UPDATE userdata SET username='$name', phone='$phone', gender='$gender', status='$status' WHERE id=$id";
    if (mysqli_query($conn, $update)) {
        echo "<script>alert('User updated successfully!'); window.location.href='users_data.php';</script>";
    } else {
        echo "<script>alert('Error updating user!');</script>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/user_edit.css">
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-user-pen"></i> User Edit</h1>
            <div class="user-profile">
                <i class="fa-solid fa-pen-to-square fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main container -->
        <!-- <div class="container py-5"> -->
        <div class="card shadow border-0" id="card-box">
            <div class="card-body">
                <div class="text-center mb-3">
                    <?php
                    // Image logic
                    $image_path = "";
                    if (!empty($user['image'])) {
                        $image_path = "../store/images/user_img/" . htmlspecialchars($user['image']);
                    } else {
                        if ($user['gender'] == 1) {
                            $image_path = "../store/images/user_img/male_default_img.png";
                        } elseif ($user['gender'] == 2) {
                            $image_path = "../store/images/user_img/female_default_img.png";
                        } else {
                            $image_path = "../store/images/user_img/default_img.jpeg";
                        }
                    }
                    ?>
                    <img src="<?php echo $image_path; ?>" alt="User Image" class="rounded-circle shadow-sm" width="100"
                        height="100" style="object-fit: cover;">
                </div>
                <form method="POST">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Username</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="<?php echo htmlspecialchars($user['email']); ?>" disabled required>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" id="phone" name="phone" class="form-control"
                                value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="gender" class="form-label fw-semibold">Gender</label>
                            <select id="gender" name="gender" class="form-select" required>
                                <option value="1" <?php if ($user['gender'] == '1')
                                    echo "selected"; ?>>Male</option>
                                <option value="2" <?php if ($user['gender'] == '2')
                                    echo "selected"; ?>>Female</option>
                                <option value="0" <?php if ($user['gender'] == '0' || $user['gender'] == '' || $user['gender'] == NULL)
                                    echo "selected"; ?>>Other</option>
                            </select>

                        </div>
                        <!-- Address -->
                        <div class="col-12">
                            <label for="address" class="form-label fw-semibold">Address</label>
                            <textarea id="address" name="address" rows="3" class="form-control" disabled
                                required><?php echo htmlspecialchars($user['address']); ?></textarea>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="1" <?php if ($user['status'] == '1')
                                    echo "selected"; ?>>Active</option>
                                <option value="2" <?php if ($user['status'] == '2')
                                    echo "selected"; ?>>Inactive</option>
                            </select>

                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="users_data.php" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Update User
                        </button>
                    </div>
                </form>

            </div>
        </div>
        <!-- </div> -->
        <br>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>