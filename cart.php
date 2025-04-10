<?php
include 'require/config.php'; // Database connection

// Assume CustomerID is stored in session
$customerID = $_SESSION['CustomerID'];

// Handle Delete
if (isset($_GET['delete'])) {
    $cartId = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM cart WHERE cartId = $cartId AND CustomerID = $customerID");
    header("Location: cart.php");
    exit();
}
// Fetch Cart Items
$sql = "SELECT c.cartId, c.quantity, p.ProductID, p.ProductName, p.Price, p.ImagePath 
        FROM cart c 
        JOIN products p ON c.ProductID = p.ProductID 
        WHERE c.CustomerID = $customerID";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest | Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/nav&footer.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/alert.css">
</head>

<body>
    <?php require 'require/nav.php'; ?>
    <div class="cart-container">
        <h1>Shopping Cart</h1>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                while ($row = mysqli_fetch_assoc($result)):
                    $total = intval($row['Price']) * intval($row['quantity']);
                    $grandTotal += $total;
                ?>
                    <tr id="cart-row-<?= $row['cartId'] ?>">
                        <td data-label="Product">
                            <div class="cart-product">
                                <img src="<?= $row['ImagePath'] ?>" alt="<?= $row['ProductName'] ?>">
                                <div><?= $row['ProductName'] ?></div>
                            </div>
                        </td>
                        <td data-label="Price">₹<?= number_format($row['Price'], 2) ?></td>
                        <td data-label="Quantity">
                            <div class="quantity-control">
                                <button class="quantity-btn minus-btn" id="<?= $row['cartId'] ?>">-</button>
                                <span class="quantity"><?= $row['quantity'] ?></span>
                                <button class="quantity-btn plus-btn" id="<?= $row['cartId'] ?>">+</button>
                            </div>
                        </td>
                        <td data-label="Total" class="item-total">₹<?= number_format($total, 2) ?></td>
                        <td data-label="Action">
                            <a href="?delete=<?= $row['cartId'] ?>" class="delete-btn"
                                onclick="return confirm('Remove this item?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="cart-total">
            Total: ₹<span id="grand-total"><?= number_format($grandTotal, 2) ?></span>
        </div>
        <button class="checkout-btn" onclick="window.location='Allproduct.php'">Continue Shopping</button>
        <?php if ($grandTotal > 0): ?>
            <button class="checkout-btn" onclick="openModal(checkoutModal)">Proceed to Checkout</button>
        <?php endif; ?>
    </div>
    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal">
        <div class="modal-content">
            <h2>Checkout Details</h2>
            <form id="checkoutForm" method="post">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" <?php echo 'value="' . htmlspecialchars($custDetails['FullName'] ?? '') . '"'; ?> required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" <?php echo 'value="' . htmlspecialchars($custDetails['Email'] ?? '') . '"'; ?> required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" <?php echo 'value="' . htmlspecialchars($custDetails['PhoneNumber'] ?? '') . '"'; ?> required>
                </div>
                <div class="form-group">
                    <label for="address">Shipping Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="paymentMethod">Payment Method</label>
                    <select name="paymentMethod" id="paymentMethod" required>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Card Payment">Card Payment</option>
                        <option value="UPI">UPI</option>
                    </select>
                </div>
                <button type="submit" class="checkout-btn">Order</button>
                <button type="button" onclick="closeModal(checkoutModal)" class="delete-btn ">Cancel</button>
            </form>
        </div>
    </div>
    <?php
    require 'require/footer.html';
    ?>
    <script src="js/cart.js"></script>
</body>

</html>