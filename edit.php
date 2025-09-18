<?php
require "db_connect.php";

if (isset($_POST['update'])) {
    $id = $_GET['id'];
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $gender = trim($_POST['gender']);

    $stmt = mysqli_prepare($conn, "UPDATE userdata SET username=?, phone=?, city=?, gender=? WHERE id=?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssssi', $username, $phone, $city, $gender, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: dashboard.php?Status=Success");
            exit();
        } else {
            echo "<script>alert('User Data Not Updated!');window.location.href='dashboard.php?Status=Failed';</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement.');window.location.href='dashboard.php?Status=Failed';</script>";
    }
}



$stmt = mysqli_prepare($conn, "SELECT * FROM userdata WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $email = $row['email'];
    $phone = $row['phone'];
    $city = $row['city'];
    $gender = $row['gender'];
}
?>
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

    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
        href="/css/app-wa-6c2cfb834ff69809c67c5d613feb4d68.css?vsn=d">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/fontawesome.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/whiteboard-semibold.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/thumbprint-light.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/slab-press-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/slab-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-duotone-thin.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-duotone-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-duotone-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-duotone-light.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-thin.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/sharp-light.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/notdog-duo-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/notdog-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/jelly-fill-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/jelly-duo-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/jelly-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/etch-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/duotone-thin.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/duotone.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/duotone-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/duotone-light.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/thin.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/solid.css">

    <title>Edit</title>
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

        <form method="post" class="form-control mt-5 p-4" id="myForm" style="height:auto; width:380px;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px,
            rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row text-center">
                <h5 class="p-4" style="font-weight: 700;">Update Profile :</h5>
            </div>
            <div class="mb-2">
                <label for="username"><i class="fa-duotone fa-solid fa-user"></i> User Name :</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo $username; ?>"
                    required minilength="2">
            </div>
            <div class="mb-2 mt-2">
                <label for="email"><i class="fa-duotone fa-regular fa-envelope-circle-user"></i> Email :</label>
                <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required
                    minlength="5">
            </div>
            <div class="mb-2 mt-2">
                <label for="phone"><i class="fa-notdog fa-solid fa-phone"></i> Phone :</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $phone; ?>" required
                    minlength="10" maxlength="10">
            </div>
            <div class="mb-2 mt-2">
                <label for="city"><i class="fa-notdog-duo fa-solid fa-location-dot"></i> City :</label>
                <input type="text" name="city" id="city" class="form-control" value="<?php echo $city; ?>" required
                    minlength="3">
            </div>
            <div class="mb-2 mt-2">
                <label for="gender"><i class="fa-duotone fa-solid fa-venus"></i> Gender :</label><br>
                <input type="radio" name="gender" value="1" <?php if ($gender == '1')
                    echo 'checked'; ?>> Male
                &nbsp;&nbsp;

                <input type="radio" name="gender" value="2" <?php if ($gender == '2')
                    echo 'checked'; ?>> Female
                &nbsp;&nbsp;

                <input type="hidden" name="gender" value="2" <?php if ($gender == '')
                    echo 'checked'; ?> disabled>
                &nbsp;&nbsp;
            </div>
            <div class="mb-2 mt-3">
                <button type="submit" class="btn btn-success
                bg-success" name="update" style="font-weight: 600;">Update</button>
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
                        phone: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            digits: true
                        },
                        city: {
                            required: true,
                            minlength: 3
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
                        phone: {
                            required: "Please enter your phone number",
                            minlength: "Your phone number must be at least 10 digits long",
                            maxlength: "Your phone number must not exceed 10 digits",
                            digits: "Please enter only digits"
                        },
                        city: {
                            required: "Please enter your city",
                            minlength: "Your city must consist of at least 3 characters"
                        }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });
            });
        </script>
    </div>
</body>

</html>