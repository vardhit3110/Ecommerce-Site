<?php
session_start();
require 'db_connect.php';

$errors = '';
$success = '';

$token = isset($_GET['token']) ? $_GET['token'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';

if (!$token || !$email) {
    die("Invalid or missing token.");
}

// Verify token & expiry
$stmt = $conn->prepare("SELECT id, reset_expires FROM userdata WHERE email = ? AND reset_token = ? LIMIT 1");
$stmt->bind_param('ss', $email, $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Invalid token or email.");
}
$row = $res->fetch_assoc();
$userId = $row['id'];
$expires = $row['reset_expires'];

if (strtotime($expires) < time()) {
    die("This reset link has expired. Please request a new password reset.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

    if (strlen($password) < 6) {
        $errors = "Password must be at least 6 characters.";
    } elseif ($password !== $password2) {
        $errors = "Passwords do not match.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $update = $conn->prepare("UPDATE userdata SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $update->bind_param('si', $passwordHash, $userId);
        if ($update->execute()) {
            // success
            $success = "Your password has been reset successfully. You may now login.";
            header("Location: index.php?reset=1");
            exit;
        } else {
            $errors = "Failed to update password. Try again later.";
        }
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Set New Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #ffffff;
            background: radial-gradient(circle, rgba(255, 255, 255, 1) 0%, rgba(148, 187, 233, 1) 100%);
        }

        .container {
            max-width: 500px;
            margin-top: 80px;
        }

        .password-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
            transition: all 0.3s ease;
        }

        .password-card:hover {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #ccc;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: none;
        }

        .btn-primary {
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .alert {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="password-card">
            <h3>Set a new password</h3>
            <?php if ($errors): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($errors); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password2" class="form-control" required>
                </div>
                <button class="btn btn-primary" type="submit">Set Password</button>
            </form>
        </div>
    </div>
</body>

</html>