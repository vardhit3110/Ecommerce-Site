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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            display: flex;
            justify-content: center;
            max-width: 1200px;
            margin: 20px auto;
            gap: 20px;
        }

        .wishlist-content {
            flex: 0 0 80%;
            max-width: 800px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .wishlist-header h1 {
            font-size: 1.5rem;
            color: #333;
        }

        .wishlist-items {
            display: grid;
            gap: 20px;
        }

        .wishlist-item {
            display: flex;
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
        }

        .wishlist-item:hover {
            text-decoration: none;
            color: inherit;
        }

        .item-image {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #fff;
        }

        .item-details {
            flex: 1;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .item-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
        }

        .item-description {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 10px;
        }

        .item-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #e74c3c;
        }

        .delete-btn {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 5px;
            margin-left: auto;
            align-self: flex-start;
        }

        .delete-btn:hover {
            color: #c0392b;
        }

        /* Popup Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 150px;
            max-width: 35%;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .modal-icon {
            font-size: 3rem;
            color: #e74c3c;
            margin-bottom: 15px;
        }

        .modal h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .modal p {
            margin-bottom: 20px;
            color: #666;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid #ddd;
        }

        .btn-outline:hover {
            background-color: #f8f9fa;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .wishlist-content {
                flex: none;
                width: 100%;
            }

            .wishlist-item {
                flex-direction: column;
            }

            .item-image {
                width: 100%;
                height: 200px;
            }
        }

        .empty-wishlist {
            text-align: center;
            padding: 40px 20px;
            color: #888;
        }

        .empty-wishlist img {
            max-width: 350px;
            height: auto;
            margin-bottom: 20px;
            opacity: 0.7;
        }

        .empty-wishlist p {
            font-size: 1.2rem;
            font-weight: 500;
        }
    </style>
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