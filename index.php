<?php
require "db_connect.php";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];


    $check_email = "SELECT * FROM userdata WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result_email = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_email) > 0) {
        echo "<script>alert('Email Already Registered');</script>";
    } else {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);


        $reg_query = "INSERT INTO userdata (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $reg_query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>alert('Register Successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Registration Failed. Please try again later.');</script>";
        }
    }
}
?>

<!-- username@123 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/295/295128.png"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validation/1.19.5/jquery.validate.min.js"></script>
    <title>Registration</title>
</head>

<body class="bg-light">
    <div class="container p-5 d-flex flex-column align-items-center">

        <form method="post" class="form-control mt-5 p-4" id="myform" style="height:auto; width:380px;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
            rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row text-center">
                <i class="fa fa-user-circle-o fa-3x mt-1 mb-2" style="color: green;"></i>
                <h5 class="p-4" style="font-weight: 700;">Create Your Account</h5>
            </div>
            <div class="mb-2">
                <label for="username"><i class="fa fa-user"></i> User Name</label>
                <input type="text" name="username" id="username" class="form-control" required minilength="2">
            </div>
            <div class="mb-2 mt-2">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="text" name="email" id="email" class="form-control" required minlength="5">
            </div>
            <div class="mb-2 mt-2">
                <label for="password"><i class="fa fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-2 mt-3">
                <button type="submit" class="btn btn-success
                bg-success" name="register" style="font-weight: 600;">Create
                    Account</button>
            </div>
            <div class="mb-2 mt-4">
                <p class="text-center" style="font-weight: 600; 
                color: navy;">I have an Account <a href="./login.php" style="text-decoration: none;">Login</a></p>
            </div>
        </form>
    </div>

    <!-- form validate -->
    <script>
        $(document).redy(function () {
            $("#myform").validate({
                rules: {
                    username: {
                        required: true,
                        minilenghth: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minilenghth: 6
                    }
                },
                message: {
                    username: {
                        required: "Please enter username",
                        minlength: "Your username must be at least 2 characters long"
                    },
                    email: {
                        required: "Please enter email",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please enter password",
                        minlength: "Your password must be at least 6 characters long"
                    }
                },
                submitHandler: function (form) {
                    alert("Form is valid and ready to submit!");
                    form.submit();
                }
            })
        });
    </script>
</body>

</html>