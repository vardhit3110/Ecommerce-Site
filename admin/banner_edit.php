<?php
require "slider.php";
require "db_connect.php";

// Check if we're in update mode
$update_mode = false;
$banner = [
    'id' => '',
    'title' => '',
    'sub_title' => '',
    'image_path' => ''
];

if (isset($_GET['edit'])) {
    $update_mode = true;
    $id = intval($_GET['edit']);
    $query = "SELECT * FROM banners WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $banner = mysqli_fetch_assoc($result);
    } else {
        echo "<script>alert('Banner not found!'); window.location.href='banner.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $update_mode ? 'View / Update Banner' : 'Add New Banner' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php require "links/icons.html"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/banner_edit.css">
</head>

<body>
    <div class="main-content">
        <div class="container mt-4">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h3 class="fw-bold text-start mb-4">
                        <i class="bi bi-image"></i>
                        <?= $update_mode ? 'View / Update Banner' : 'Add New Banner' ?>
                    </h3>

                    <form action="<?= $update_mode ? './partials/update_banner.php' : './partials/insert_banner.php' ?>"
                        method="POST" enctype="multipart/form-data">

                        <?php if ($update_mode): ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($banner['id']) ?>">
                        <?php endif; ?>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter banner title"
                                value="<?= htmlspecialchars($banner['title']) ?>" required>
                        </div>

                        <!-- Sub Title -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Sub Title</label>
                            <input type="text" name="sub_title" class="form-control"
                                placeholder="Enter banner sub title"
                                value="<?= htmlspecialchars($banner['sub_title']) ?>" required>
                        </div>

                        <!-- Banner Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Banner Image</label>
                            <div class="img-preview mb-2" id="imagePreview">
                                <?php if ($update_mode && !empty($banner['image_path'])): ?>
                                    <img src="<?= htmlspecialchars($banner['image_path']) ?>" alt="Current Banner">
                                <?php else: ?>
                                    <span class="text-muted">Click to upload image</span>
                                <?php endif; ?>
                            </div>

                            <!-- Show upload only if adding new banner -->
                            <?php if (!$update_mode): ?>
                                <input type="file" class="form-control" id="imageInput" name="image_path" accept="image/*"
                                    required>
                            <?php else: ?>
                                <input type="text" class="form-control read-only"
                                    value="<?= htmlspecialchars($banner['image_path']) ?>" readonly>
                            <?php endif; ?>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <?php if ($update_mode): ?>
                                <button type="submit" class="btn btn-primary btn-custom px-4 py-2">
                                    <i class="bi bi-pencil-square"></i> Update
                                </button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-success btn-custom px-4 py-2">
                                    <i class="bi bi-save"></i> Save
                                </button>
                            <?php endif; ?>

                            <a href="banner.php" class="btn btn-secondary btn-custom px-3 py-2">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="footer">
                <p>&copy; 2025 Admin Panel. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        // Image preview only when adding
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');

        if (imageInput) {
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
        }
    </script>
</body>

</html>