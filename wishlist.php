<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileSite</title>
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

        .likeproduct {
            text-decoration: none;
        }
        #like {
            color: dark;
        }

        #like:hover {
            color: #0056b3;
        }

        .container {
            display: flex;
            justify-content: center;
            max-width: 1200px;
            margin: 20px auto;
            gap: 20px;
        }

        /* Wishlist Content Styles */
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
            /* Removed hover effects */
        }

        .item-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
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
        }

        .item-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #e74c3c;
            margin: 10px 0;
        }

        .item-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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

        .delete-btn {
            background: none;
            border: none;
            color: #6c757d;
            /* Secondary color */
            cursor: pointer;
            font-size: 1.2rem;
            padding: 5px;
            margin-left: auto;
            align-self: flex-start;
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
            width: 400px;
            max-width: 90%;
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

        /* Responsive Design */
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
    </style>
</head>

<body>
    <?php require "header.php"; ?>
    <div class="container">
        <!-- Wishlist Content -->
        <div class="wishlist-content">
            <div class="wishlist-header">
                <h1>My Wishlist (3 items)</h1>
            </div>

            <div class="wishlist-items">
                <!-- Wishlist Item 1 -->
                <a href="#" class="likeproduct">
                    <div class="wishlist-item">
                        <img src="" alt="Product" class="item-image">
                        <div class="item-details">
                            <div>
                                <h3 class="item-title text-dark " id="like">Wireless Bluetooth Headphones</h3>
                                <p class="item-description text-dark">High-quality sound with noise cancellation feature
                                    and
                                    30-hour
                                    battery life.
                                </p>
                                <div class="item-price">$129.99</div>
                            </div>
                            <div class="item-actions">
                                <!-- <a href="#" class="btn text-primary-">Move To Cart</a> -->
                                <!-- <button class="btn btn-outline">Save for Later</button> -->
                            </div>
                        </div>
                        <button class="delete-btn" onclick="openDeleteModal(1)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>div>
                </a>

                <!-- Wishlist Item 2 -->
                <div class="wishlist-item">
                    <img src="" alt="Product" class="item-image">
                    <div class="item-details">
                        <div>
                            <h3 class="item-title">Smart Fitness Watch</h3>
                            <p class="item-description">Track your heart rate, steps, and sleep with this advanced
                                fitness tracker.
                            </p>
                            <div class="item-price">$199.99</div>
                        </div>
                        <div class="item-actions">
                            <button class="btn btn-primary">Move to Cart</button>
                            <button class="btn btn-outline">Save for Later</button>
                        </div>
                    </div>
                    <button class="delete-btn" onclick="openDeleteModal(2)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>

                <!-- Wishlist Item 3 -->
                <div class="wishlist-item">
                    <img src="" alt="Product" class="item-image">
                    <div class="item-details">
                        <div>
                            <h3 class="item-title">Portable Bluetooth Speaker</h3>
                            <p class="item-description">Waterproof speaker with 360-degree sound and 12-hour battery
                                life.</p>
                            <div class="item-price">$79.99</div>
                        </div>
                        <div class="item-actions">
                            <button class="btn btn-primary">Move to Cart</button>
                            <button class="btn btn-outline">Save for Later</button>
                        </div>
                    </div>
                    <button class="delete-btn" onclick="openDeleteModal(3)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                <button class="btn btn-danger" onclick="confirmDelete()">Remove</button>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>
</body>

</html>