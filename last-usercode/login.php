<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <title>Login Page</title>
    <style>
        .error {
            color: red;
            font-size: 14px;
            margin-top: 3px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container p-5 d-flex flex-column align-items-center">
        <form action="partials/_login.php" method="post" id="myForm" class="form-control mt-5 p-4" style="height:auto; width:380px; box-shadow: rgba(60, 64, 67, 0.3) myForm
            0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row">
                <i class="fa fa-user-circle-o fa-3x mt-1 mb-2" style="text-align: center; color: green;"></i>
                <h5 class="text-center p-4" style="font-weight: 700;">Login Into Your Account</h5>
            </div>
            <div class="col-mb-3">
                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                <input type="email" name="email" id="email" class="form-control">
                <div id="emailError" class="error"></div>
            </div>
            <div class="col mb-3 mt-3">
                <label for="password"><i class="fa fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <div id="passwordError" class="error"></div>
            </div>
            <div class="col mb-3 mt-3">
                <button type="submit" class="btn btn-success bg-success" name="login"
                    style="font-weight: 600;">Login</button>
            </div>
            <div class="col mb-2 mt-4">
                <p class="text-center" style="font-weight: 600; color: navy;"><a href="./index.php"
                        style="text-decoration: none;">Create Account</a>
                </p>
            </div>
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
                    /*  */
                    form.submit();
                }
            });
        });
    </script>
</body>

</html>