<?php
include 'require/config.php';

// Check if user is logged in
if (!isset($_SESSION['CustomerID'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['CustomerID'];

// Get user type (admin or customer)
$userQuery = "SELECT type FROM customer WHERE CustomerID = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$isAdmin = $user['type'] == 1;

// Handle status update (admin only)
if ($isAdmin && isset($_POST['updateStatus'])) {
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['status'];
    $updateQuery = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $newStatus, $orderId);
    $stmt->execute();
}

// Handle order cancellation (customer only)
if (!$isAdmin && isset($_POST['cancelOrder'])) {
    $orderId = $_POST['orderId'];
    $updateQuery = "UPDATE orders SET status = 'Cancelled' WHERE order_id = ? AND CustomerID = ? AND status != 'Delivered'";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ii", $orderId, $customerID);
    $stmt->execute();
}

// Fetch orders based on user type
if ($isAdmin) {
    $orderQuery = "SELECT * FROM orders ORDER BY order_date DESC";
    $stmt = $conn->prepare($orderQuery);
} else {
    $orderQuery = "SELECT * FROM orders WHERE CustomerID = ? ORDER BY order_date DESC";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param("i", $customerID);
}
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest | Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/nav&footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="css/alert.css">
</head>

<body>
    <?php require 'require/nav.php'; ?>

    <div class="orders-container">
        <h1 class="section-title"><?php echo $isAdmin ? 'All Orders' : 'My Orders'; ?></h1>

        <?php while ($order = $orders->fetch_assoc()): ?>
            <div class="order-card" id="order-<?php echo $order['order_id']; ?>">
                <div class="order-header">
                    <div>
                        <h3>Order ID: <?php echo $order['order_id']; ?></h3>
                        <p>Ordered on: <?php echo date('F j, Y', strtotime($order['order_date'])); ?></p>
                    </div>
                    <span class="status-badge status-<?php echo $order['status']; ?>">
                        <?php echo $order['status']; ?>
                    </span>
                </div>

                <div class="order-details">
                    <div class="shipping-info">
                        <p><strong>Name:</strong> <?php echo $order['fullName']; ?></p>
                        <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                        <p><strong>Phone Number:</strong> <?php echo $order['phone']; ?></p>
                        <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
                        <p><strong>Payment Method:</strong> <?php echo $order['PayMode']; ?></p>
                    </div>

                    <div class="product-list">
                        <?php
                        $products = json_decode($order['products'], true);
                        foreach ($products as $product): ?>
                            <div class="product-item">
                                <p><?php echo $product['product_name']; ?> x <?php echo $product['quantity']; ?> = ₹<?php echo $product['price']*$product['quantity']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <p><strong>Total Amount:</strong> ₹<?php echo number_format($order['total_price'], 2); ?></p>

                    <div class="action-buttons">
                        <button type="button" class="btn print-btn" onclick="printOrder(<?php echo $order['order_id']; ?>)">
                            <i class="fas fa-print"></i> Print Order
                        </button>
                        <?php if ($isAdmin): ?>
                            <form method="post" class="status-form">
                                <input type="hidden" name="orderId" value="<?php echo $order['order_id']; ?>">
                                <select name="status" required>
                                    <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                    <option value="Delivered" <?php echo $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="updateStatus" class="btn update-btn">Update Status</button>
                            </form>
                        <?php else: ?>
                            <?php if ($order['status'] != 'Delivered' && $order['status'] != 'Cancelled'): ?>
                                <form method="post" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                    <input type="hidden" name="orderId" value="<?php echo $order['order_id']; ?>">
                                    <button type="submit" name="cancelOrder" class="btn cancel-btn">Cancel Order</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php require 'require/footer.html'; ?>

    <script src="js/orders.js"></script>
</body>

</html>