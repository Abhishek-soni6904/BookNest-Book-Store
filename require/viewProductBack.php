<?php
// Database connection
include 'require/config.php';

// Function to add or update product in cart
function addOrUpdateCart($conn, $CustomerID, $ProductID, $quantity) {
    // Check if the product is already in the cart
    $check_query = "SELECT quantity FROM cart WHERE CustomerID = ? AND ProductID = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "ii", $CustomerID, $ProductID);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        // Product is already in the cart
        $existing_data = mysqli_fetch_assoc($check_result);
        $existing_quantity = $existing_data['quantity'];

        // Update the quantity
        $new_quantity = $existing_quantity + $quantity;
        $update_query = "UPDATE cart SET quantity = ? WHERE CustomerID = ? AND ProductID = ?";
        $update_stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($update_stmt, "iii", $new_quantity, $CustomerID, $ProductID);
        mysqli_stmt_execute($update_stmt);
        $_SESSION['message'] = "Product was already present. Quantity updated to $new_quantity.";
    } else {
        // Add the product to the cart
        $cart_query = "INSERT INTO cart (CustomerID, ProductID, quantity) VALUES (?, ?, ?)";
        $cart_stmt = mysqli_prepare($conn, $cart_query);
        mysqli_stmt_bind_param($cart_stmt, "iii", $CustomerID, $ProductID, $quantity);
        mysqli_stmt_execute($cart_stmt);
        $_SESSION['message'] = "Product added to cart successfully.";
    }
}

// Get product ID from URL
$ProductID = isset($_GET['id']) ? intval($_GET['id']) : die('Product ID not specified');

// Fetch product details
$query = "SELECT * FROM products WHERE ProductID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $ProductID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $CustomerID = $_SESSION['CustomerID'];
    $quantity = intval($_POST['quantity']);
    
    // Use the reusable function
    addOrUpdateCart($conn, $CustomerID, $ProductID, $quantity);

    // Set session message
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $ProductID);
    exit();
}

// Handle Buy Now
if (isset($_POST['buy_now'])) {
    $CustomerID = $_SESSION['CustomerID'];
    $quantity = intval($_POST['quantity']);
    
    // Use the reusable function
    addOrUpdateCart($conn, $CustomerID, $ProductID, $quantity);

    // Redirect to the cart page
    header("Location: cart.php");
    exit();
}

if(isset($_POST['delete'])){
    $query = "DELETE FROM products WHERE ProductID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $ProductID);
    mysqli_stmt_execute($stmt);
    $_SESSION['message'] = "Product deleted successfully.";
    header("Location: index.php");
    exit();
}
?>
