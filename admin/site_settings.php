<?php
require "slider.php";
require "db_connect.php";

// Fetch existing site details
$query = "SELECT * FROM sitedetail LIMIT 1";
$result = mysqli_query($conn, $query);
$site = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $systemName = mysqli_real_escape_string($conn, $_POST['systemName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $update = "UPDATE sitedetail SET systemName='$systemName', email='$email', contact='$contact', address='$address' WHERE id=" . $site['id'];
    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Site details updated successfully!'); window.location.href='site_settings.php';</script>";
    } else {
        echo "<script>alert('Update failed: " . mysqli_error($conn) . "');</script>";
    }
}
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
            margin: 50px auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 25px 35px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .card-header {
            background-color: var(--dark);
            color: white;
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-gear"></i> Site Settings</h1>
            <div class="user-profile">
                <i class="fa-solid fa-message-smile fa-2x"></i>&nbsp;
            </div>
        </div>
        <div class="container mt-0">
            <div class="card shadow-sm border-1">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> Update Website Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" autocomplete="off">
                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-globe"></i> System Name</label>
                            <input type="text" name="systemName" class="form-control" required
                                value="<?php echo htmlspecialchars($site['systemName']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-envelope"></i> Email</label>
                            <input type="email" name="email" class="form-control" required
                                value="<?php echo htmlspecialchars($site['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-phone"></i> Contact Number</label>
                            <input type="text" name="contact" class="form-control" required
                                value="<?php echo htmlspecialchars($site['contact']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fa-solid fa-location-dot"></i> Address</label>
                            <textarea name="address" class="form-control" rows="3"
                                required><?php echo htmlspecialchars($site['address']); ?></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4"> Save
                                Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>