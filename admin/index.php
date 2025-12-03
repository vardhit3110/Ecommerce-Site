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
        <style> :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --accent: #7209b7;
        }

        body {
            background: url('https://images.unsplash.com/photo-1506765515384-028b60a970df') no-repeat center center/cover;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Background overlay to make login box visible */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(2px);
            z-index: -1;
        }

        .login-box {
            width: 400px;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-box h5 {
            font-weight: 700;
            color: #fff;
        }

        .form-control {
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .form-control::placeholder {
            color: #eee;
        }

        .form-control:focus {
            border-color: #4cc9f0;
            background-color: rgba(255, 255, 255, 0.3);
            box-shadow: none;
            color: white;
        }

        .btn-custom {
            background: linear-gradient(135deg, #4cc9f0, #4361ee);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            transition: 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #3a0ca3, #4361ee);
            transform: translateY(-2px);
        }

        .login-icon {
            color: #4cc9f0;
            font-size: 40px;
            margin-bottom: 10px;
        }

        .error {
            color: #ffb3b3;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>

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