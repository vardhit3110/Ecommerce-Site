<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f1f4f9;
        }

        .login-box {
            width: 400px;
            background: #fff;
            padding: 40px;
            margin-top: 80px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .login-box h5 {
            font-weight: 700;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
            background-color: #fff;
        }

        .btn-custom {
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .login-icon {
            color: #007bff;
            font-size: 40px;
            margin-bottom: 10px;
        }

        .create-account-link {
            text-align: center;
            margin-top: 20px;
        }

        .create-account-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }

        .create-account-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center flex-column">
        <form action="partials/admin_login.php" method="post" id="myForm" class="login-box">
            <div class="text-center">
                <i class="fa fa-user-circle fa-3x"></i><br>
                <h5>Admin Login</h5>
            </div>

            <div class="mb-3 mt-4">
                <label for="email"><i class="fa fa-envelope"></i> Email :</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                <div id="emailError" class="error"></div>
            </div>

            <div class="mb-4">
                <label for="password"><i class="fa fa-lock"></i> Password :</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                <div id="passwordError" class="error"></div>
            </div>

            <button type="submit" class="btn btn-custom" name="login">Login</button>

        </form>
    </div>

    <script>
        $(document).ready(function () {
            $("#myForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>

</body>

</html>