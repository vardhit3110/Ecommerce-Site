<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Wishlist</title>
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
      max-width: 1200px;
      margin: 20px auto;
      gap: 20px;
    }

    /* Left Navigation Styles */
    .left-nav {
      flex: 0 0 250px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 20px 0;
    }

    .nav-item {
      padding: 12px 20px;
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
    }

    .nav-item:hover {
      background-color: #f0f0f0;
    }

    .nav-item.active {
      background-color: #e8f4ff;
      border-left: 4px solid #007bff;
      font-weight: 600;
    }

    .nav-item i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    .nav-submenu {
      padding-left: 40px;
      font-size: 0.9em;
    }

    .nav-submenu .nav-item {
      padding: 8px 20px;
    }

    /* Wishlist Content Styles */
    .wishlist-content {
      flex: 1;
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
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .wishlist-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
      color: #999;
      cursor: pointer;
      font-size: 1.2rem;
      padding: 5px;
      margin-left: auto;
      align-self: flex-start;
    }

    .delete-btn:hover {
      color: #e74c3c;
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

      .left-nav {
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
  <div class="container">
    <!-- Left Navigation -->
    <div class="left-nav">
      <div class="nav-item">
        <span>Hello</span>
      </div>
      <div class="nav-item">
        <span>MY ORDERS</span>
      </div>
      <div class="nav-item">
        <span>ACCOUNT SETTINGS</span>
      </div>
      <div class="nav-submenu">
        <div class="nav-item">
          <span>Profile Information</span>
        </div>
        <div class="nav-item">
          <span>Manage Addresses</span>
        </div>
        <div class="nav-item">
          <span>PAN Card Information</span>
        </div>
      </div>
      <div class="nav-item">
        <span>PAYMENTS</span>
      </div>
      <div class="nav-item active">
        <span>MY WISHLIST</span>
      </div>
    </div>

    <!-- Wishlist Content -->
    <div class="wishlist-content">
      <div class="wishlist-header">
        <h1>My Wishlist (3 items)</h1>
      </div>

      <div class="wishlist-items">
        <!-- Wishlist Item 1 -->
        <div class="wishlist-item">
          <img src="https://via.placeholder.com/150" alt="Product" class="item-image">
          <div class="item-details">
            <div>
              <h3 class="item-title">Wireless Bluetooth Headphones</h3>
              <p class="item-description">High-quality sound with noise cancellation feature and 30-hour battery life.
              </p>
              <div class="item-price">$129.99</div>
            </div>
            <div class="item-actions">
              <button class="btn btn-primary">Move to Cart</button>
              <button class="btn btn-outline">Save for Later</button>
            </div>
          </div>
          <button class="delete-btn" onclick="openDeleteModal(1)">×</button>
        </div>

        <!-- Wishlist Item 2 -->
        <div class="wishlist-item">
          <img src="https://via.placeholder.com/150" alt="Product" class="item-image">
          <div class="item-details">
            <div>
              <h3 class="item-title">Smart Fitness Watch</h3>
              <p class="item-description">Track your heart rate, steps, and sleep with this advanced fitness tracker.
              </p>
              <div class="item-price">$199.99</div>
            </div>
            <div class="item-actions">
              <button class="btn btn-primary">Move to Cart</button>
              <button class="btn btn-outline">Save for Later</button>
            </div>
          </div>
          <button class="delete-btn" onclick="openDeleteModal(2)">×</button>
        </div>

        <!-- Wishlist Item 3 -->
        <div class="wishlist-item">
          <img src="https://via.placeholder.com/150" alt="Product" class="item-image">
          <div class="item-details">
            <div>
              <h3 class="item-title">Portable Bluetooth Speaker</h3>
              <p class="item-description">Waterproof speaker with 360-degree sound and 12-hour battery life.</p>
              <div class="item-price">$79.99</div>
            </div>
            <div class="item-actions">
              <button class="btn btn-primary">Move to Cart</button>
              <button class="btn btn-outline">Save for Later</button>
            </div>
          </div>
          <button class="delete-btn" onclick="openDeleteModal(3)">×</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Popup -->
  <div id="deleteModal" class="modal">
    <div class="modal-content">
      <div class="modal-icon">!</div>
      <h2>Remove from Wishlist</h2>
      <p>Are you sure you want to remove this item from your wishlist?</p>
      <div class="modal-actions">
        <button class="btn btn-outline" onclick="closeDeleteModal()">Cancel</button>
        <button class="btn btn-danger" onclick="confirmDelete()">Remove</button>
      </div>
    </div>
  </div>

  <script>
    let itemToDelete = null;

    function openDeleteModal(itemId) {
      itemToDelete = itemId;
      document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
      document.getElementById('deleteModal').style.display = 'none';
      itemToDelete = null;
    }

    function confirmDelete() {
      if (itemToDelete) {
        // In a real application, you would send a request to the server here
        alert(`Item ${itemToDelete} has been removed from your wishlist.`);

        // Close the modal
        closeDeleteModal();

        // In a real application, you would remove the item from the DOM
        // or refresh the wishlist
      }
    }

    // Close modal if user clicks outside of it
    window.onclick = function (event) {
      const modal = document.getElementById('deleteModal');
      if (event.target === modal) {
        closeDeleteModal();
      }
    }
  </script>
</body>

</html>
