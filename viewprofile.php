<?php
require "db_connect.php";
require "./partials/viewuser.php";

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    echo "<script>alert('Please Login First.');window:location:href='';</script>";
    exit;
}

/* update user code */
if (isset($_POST['update-profile']) && isset($_GET['email'])) {
    $get_email = $_GET['email'];

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $gender = $_POST['gender'];

    $stmt = mysqli_prepare($conn, "UPDATE userdata SET username = ?, email = ?, phone = ?, address = ?, city = ?, gender = ? WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $phone, $address, $city, $gender, $get_email);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Profile updated successfully.');window.location.href = window.location.href;</script>";
        exit;
    } else {
        echo "<script>alert('Error updating profile.');</script>";
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
    <style>
        .error {
            color: red;
            font-size: 13px;
            margin-top: 3px;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid transparent;
            border-radius: .25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
        }

        .me-2 {
            margin-right: .5rem !important;
        }

        #profileImage {
            cursor: pointer;
        }

        .form-control {
            margin-bottom: 17px;
        }

        label.error {
            font-size: 13px;
            color: red;
            margin-top: -22px;
            margin-bottom: 10px;
            display: block;
        }

        .card-body {
            min-height: 500px;
        }
    </style>
</head>

<body>
    <?php require_once "header.php"; ?>

    <div class="container">
        <div class="main-body">
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <!-- file change -->
                            <div class="d-flex flex-column align-items-center text-center">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="file" id="profileImageInput" name="profile_image"
                                        style="display: none;" accept="image/*">

                                    <img src="./store/images/user_img/<?php echo $image; ?>" alt="User"
                                        class="rounded-circle p-1 border border-primary border-3" width="110"
                                        id="profileImage"
                                        onerror="this.onerror=null; this.src='./store/images/user_img/default.png'">

                                    <div class="mt-3">
                                        <h4><?php echo $username; ?></h4>
                                        <p class="text-secondary mb-1"><?php echo $email; ?></p>
                                        <p class="text-muted font-size-sm"><?php echo $address; ?></p>
                                        <button class="btn btn-success" name="change-image">Change Image</button>
                                    </div>
                                </form>
                            </div>
                            <?php
                            if (isset($_POST['change-image'])) {
                                $imagepath = "store/images/user_img/";

                                $originalName = basename($_FILES["profile_image"]["name"]);
                                $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                                $fileName = $username . "_" . time() . "." . $imageFileType;

                                $targetFilePath = $imagepath . $fileName;

                                $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');

                                if (in_array($imageFileType, $allowedTypes)) {

                                    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
                                        $stmt = mysqli_prepare($conn, "UPDATE userdata SET image = ? WHERE email = ?");
                                        mysqli_stmt_bind_param($stmt, "ss", $fileName, $email);

                                        if (mysqli_stmt_execute($stmt)) {
                                            echo "<script>alert('Image updated successfully.'); window.location.href = window.location.href;</script>";
                                            exit;
                                        } else {
                                            echo "<script>alert('Error updating image in database.');</script>";
                                        }
                                        mysqli_stmt_close($stmt);

                                    } else {
                                        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                                    }

                                } else {
                                    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
                                }
                            }

                            ?>


                            <hr class="my-4">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-globe me-2 icon-inline">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="2" y1="12" x2="22" y2="12"></line>
                                            <path
                                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                            </path>
                                        </svg>Website
                                    </h6>
                                    <span class="text-secondary">https://bootdey.com</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-github me-2 icon-inline">
                                            <path
                                                d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                            </path>
                                        </svg>Github</h6>
                                    <span class="text-secondary">bootdey</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-twitter me-2 icon-inline text-info">
                                            <path
                                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                            </path>
                                        </svg>Twitter</h6>
                                    <span class="text-secondary">@bootdey</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-instagram me-2 icon-inline text-danger">
                                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                        </svg>Instagram</h6>
                                    <span class="text-secondary">bootdey</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-facebook me-2 icon-inline text-primary">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                            </path>
                                        </svg>Facebook</h6>
                                    <span class="text-secondary">bootdey</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <h4 class="mt-3 text-center text-primary">User Profile</h4>
                        <form method="POST" enctype="multipart/form-data" id="myForm">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Username</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="<?php echo $username; ?>"
                                            name="username" id="username" placeholder="Please Enter Username" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" class="form-control" value="<?php echo $email; ?>"
                                            name="email" id="email" placeholder="Please Enter Email" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="<?php echo $phone; ?>"
                                            name="phone" id="phone" placeholder="Please Enter Phone Number"
                                            maxlength="10" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">City</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="<?php echo $city; ?>" name="city"
                                            id="city" placeholder="Please Enter City" minlength="3" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="<?php echo $address; ?>"
                                            name="address" id="address" placeholder="Please Enter Address">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Gender</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="" disabled>Please Select Gender</option>
                                            <option value="1" <?php echo ($gender == '1') ? 'selected' : ''; ?>>Male
                                            </option>
                                            <option value="2" <?php echo ($gender == '2') ? 'selected' : ''; ?>>Female
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 d-flex justify-content-end text-secondary">
                                        <button type="submit" name="update-profile" class="btn btn-success px-3"><i
                                                class="fa-solid fa-floppy-disk"></i> Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "footer.php"; ?>
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
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    city: {
                        required: true,
                        minlength: 3
                    },
                    gender: {
                        required: true
                    }
                },
                messages: {
                    username: {
                        required: "Please enter a username",
                        minlength: "Username must be at least 2 characters"
                    },
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address"
                    },
                    phone: {
                        required: "Please enter a phone number",
                        digits: "Only numbers are allowed",
                        minlength: "Phone must be 10 digits",
                        maxlength: "Phone must be 10 digits"
                    },
                    city: {
                        required: "Please enter a city",
                        minlength: "City must be at least 3 characters"
                    },
                    gender: {
                        required: "Please select a gender"
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                highlight: function (element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function (element) {
                    $(element).removeClass("is-invalid");
                }
            });
        });
    </script>
    <script>
        const profileImage = document.getElementById('profileImage');
        const fileInput = document.getElementById('profileImageInput');

        profileImage.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    profileImage.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>