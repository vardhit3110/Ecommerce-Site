<?php
require "db_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in to view your wishlist.'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/wishlist.css">
</head>

<body>
    <?php require "header.php"; ?>
    <?php
    $wishlist_sql = "SELECT product.product_Id, product.product_name, product.product_image, product.product_desc, product.product_price FROM product JOIN wishlist ON product.product_Id = wishlist.prod_id WHERE wishlist.user_id = ?";
    $stmt = mysqli_prepare($conn, $wishlist_sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $wishlist_count = mysqli_num_rows($result);
    ?>
    <br><br>
    <div class="container">
        <div class="wishlist-content">
            <div class="wishlist-header">
                <h1>My Wishlist (<?php echo $wishlist_count; ?>)</h1>
            </div>
            <div class="wishlist-items">
                <?php if ($wishlist_count > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <a href="viewproduct.php?Productid=<?php echo $row['product_Id']; ?>" class="wishlist-item">
                            <img src="./admin/images/product_img/<?php echo htmlspecialchars($row['product_image']); ?>"
                                alt="Product" class="item-image">
                            <div class="item-details">
                                <div>
                                    <h3 class="item-title">
                                        <?php echo htmlspecialchars($row['product_name']); ?>
                                    </h3>
                                    <p class="item-description">
                                        <?php echo htmlspecialchars($row['product_desc']); ?>
                                    </p>
                                    <div class="item-price">₹<?php echo number_format($row['product_price']); ?></div>
                                </div>
                            </div>
                            <!-- <button class="delete-btn"
                                onclick="event.preventDefault(); removeFromWishlist(<?php echo $row['product_Id']; ?>, this)">
                                <i class="fas fa-trash-alt"></i>
                            </button> -->
                        </a>
                        <hr class="my-0 text-dark">
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-wishlist">
                        <img src="./admin/images/product_img/empty-wishlist.png" alt="Empty Wishlist">
                        <p>Your wishlist is currently empty.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div><br><br>

    <!-- Delete Confirmation Popup -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h2>Remove from Wishlist</h2>
            <p>Are you sure you want to remove this item from your wishlist?</p>
            <div class="modal-actions">
                <button class="btn btn-outline" onclick="closeDeleteModal()">Cancel</button>
                <form method="POST" action="./partials/remove_wishlist.php">
                    <input type="hidden" id="deleteProductId" name="product_id">
                    <button type="submit" name="product_id" class="btn btn-danger">Remove</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(productId) {
            document.getElementById('deleteProductId').value = productId;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        window.onclick = function (event) {
            var modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <?php require "footer.php"; ?>
    <?php
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible fade show m-0 text-center" role="alert">
            ' . $_SESSION['success'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show m-0 text-center" role="alert">
            ' . $_SESSION['error'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        unset($_SESSION['error']);
    }
    ?>
</body>

</html>