<?php
require 'require/config.php';

$data = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false];

if (isset($data['cartId']) && isset($data['quantity'])) {
    $cartId = (int)$data['cartId'];
    $quantity = (int)$data['quantity'];
    $customerID = $_SESSION['CustomerID'];

    $sql = "UPDATE cart SET quantity = $quantity 
            WHERE cartId = $cartId AND CustomerID = $customerID";

    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
    }
}

if (isset($data['checkout']) && $data['checkout'] === true) {
    $customerID = $_SESSION['CustomerID'];
    $fullName = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $address = mysqli_real_escape_string($conn, $data['address']);
    $payMode = mysqli_real_escape_string($conn, $data['paymentMethod']);

    // Fetch all necessary details from cart
    $cartQuery = "SELECT c.ProductID as product_id, p.ProductName as product_name, 
              c.quantity, p.Price as price 
              FROM cart c 
              JOIN products p ON c.ProductID = p.ProductID 
              WHERE c.CustomerID = $customerID";
    $cartResult = mysqli_query($conn, $cartQuery);

    if (!$cartResult) {
        $response['message'] = 'Error fetching cart items: ' . mysqli_error($conn);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    $products = [];
    $totalPrice = 0;

    while ($row = mysqli_fetch_assoc($cartResult)) {
        $products[] = $row;
        $totalPrice += $row['quantity'] * $row['price'];
    }

    if (!empty($products)) {
        $productsJson = json_encode($products);
        $insertOrder = "INSERT INTO orders (CustomerID, fullName, email, phone, address, products, total_price, PayMode, status, order_date) 
                        VALUES ($customerID, '$fullName', '$email', '$phone', '$address', '$productsJson', $totalPrice, '$payMode', 'Pending', NOW())";

        if (mysqli_query($conn, $insertOrder)) {
            // Clear cart after successful order placement
            $deleteCart = "DELETE FROM cart WHERE CustomerID = $customerID";
            if (mysqli_query($conn, $deleteCart)) {
                $response['success'] = true;
                $response['message'] = 'Order placed successfully';
            } else {
                $response['message'] = 'Error clearing cart: ' . mysqli_error($conn);
            }
        } else {
            $response['message'] = 'Error creating order: ' . mysqli_error($conn);
        }
    } else {
        $response['message'] = 'Cart is empty';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
