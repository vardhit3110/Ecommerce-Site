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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <title>Registration</title>
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

        <form action="partials/_register.php" method="post" class="form-control mt-5 p-4" id="myForm" style="height:auto; width:380px;
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
        <script>
            $(document).ready(function () {
                $("#myForm").validate({
                    rules: {
                        username: {
                            required: true,
                            minlength: 2
                        },
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
                        username: {
                            required: "Please enter your name",
                            minlength: "Your name must consist of at least 2 characters"
                        },
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
                        // alert("Form submitted successfully!");
                        form.submit();
                    }
                });
            });
        </script>
    </div>
</body>

</html>