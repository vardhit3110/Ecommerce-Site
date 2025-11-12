<?php
require "slider.php";
require "db_connect.php";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

        .card {
            border-radius: 15px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        input:checked+.slider {
            background-color: #7cd992;
        }

        input:checked+.slider:before {
            transform: translateX(23px);
        }

        /* Image Preview Box */
        .img-preview {
            width: 100%;
            max-width: 100%;
            height: 250px;
            border: 2px dashed #ced4da;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .img-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <div class="header">
            <h1><i class="fa-solid fa-gear"></i> Banner Manage</h1>
            <div class="user-profile">
                <i class="fa-solid fa-message-smile fa-2x"></i>&nbsp;
            </div>
        </div>
        <!-- main contact -->

        <div class="container">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-start mb-4">
                        <i class="bi bi-image"></i> Add New Banner
                    </h3>

                    <form action="./partials/insert_banner.php" method="POST" enctype="multipart/form-data">
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter banner title"
                                required>
                        </div>

                        <!-- Sub Title -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sub Title</label>
                            <input type="text" name="sub_title" class="form-control"
                                placeholder="Enter banner sub title" required>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Banner Image</label>
                            <div class="img-preview mb-2" id="imagePreview">
                                <span class="text-muted">Click to upload image</span>
                            </div>
                            <input type="file" class="form-control" id="imageInput" name="image_path" accept="image/*"
                                required>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                <i class="bi bi-save"></i> Save
                            </button>
                            <a href="banner.php" class="btn btn-secondary px-3 py-2">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');

            imageInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
        <div class="footer">
            <p>&copy; 2025 Admin Panel. All rights reserved.</p>
        </div>
    </div>

</body>

</html>