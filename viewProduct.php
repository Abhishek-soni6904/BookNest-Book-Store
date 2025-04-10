<?php require 'require/viewProductBack.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest | <?php echo htmlspecialchars($product['ProductName']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="stylesheet" href="css/nav&footer.css">
    <link rel="stylesheet" href="css/viewProduct.css">
</head>

<body>
    <?php require 'require/nav.php'; ?>
    <div class="product-container">
        <div class="product-image-container">
            <img src="<?php echo htmlspecialchars($product['ImagePath']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" class="product-image">
        </div>

        <div class="product-info">
            <h1 class="product-title"><?php echo ucwords(htmlspecialchars($product['ProductName'])); ?></h1>
            <?php if (isset($custDetails) && $custDetails['type'] == 1): ?>
                <div>
                    <a href="addProduct.php?id=<?= $ProductID ?>" class="checkout-btn">Edit</a>
                    <form method="POST" style="display: inline;">
                        <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            <?php endif; ?>
            <div class="product-details">
                <p><strong>By </strong> <?php echo strtoupper(htmlspecialchars($product['AuthorName'])); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['Category']); ?></p>
                <p><strong>Price:</strong>₹<?php echo number_format($product['Price'], 2); ?></p>
                <p><strong>Availability:</strong><span style="color:<?php echo $product['isAvailable'] ? '#00FF00' : '#FF0000'; ?>"> <?php echo $product['isAvailable'] ? 'In Stock' : 'Out of Stock'; ?></span></p>
            </div>
            <p class="product-description">
                <?php echo nl2br(htmlspecialchars($product['Description'])); ?>
            </p>

            <form method="POST">
                <div class="quantity-selector">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="99" <?php echo $product['isAvailable'] ? '' : 'disabled'; ?>>
                </div>

                <div class="button-group">
                    <?php if (isset($_SESSION['CustomerID'])): ?>
                        <button type="submit" name="add_to_cart" class="btn btn-cart" <?php echo $product['isAvailable'] ? '' : 'disabled'; ?>>Add to Cart</button>
                        <button type="submit" name="buy_now" class="btn btn-buy" <?php echo $product['isAvailable'] ? '' : 'disabled'; ?>>Buy Now</button>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-cart <?php echo $product['isAvailable'] ? '' : 'disabled'; ?>">Add to Cart</a>
                        <a href="login.php" class="btn btn-buy <?php echo $product['isAvailable'] ? '' : 'disabled'; ?>">Buy Now</a>
                    <?php endif; ?>
                </div>

            </form>

        </div>
    </div>
    <div class="reviews-section">
        <h2>Customer Reviews</h2>
        <div class="review">
            <div class="review-header">
                <span class="reviewer-name">Emma W.</span>
                <span class="stars">★★★★★</span>
            </div>
            <div class="review-date">2024-01-05</div>
            <p class="review-comment">
                Fantastic selection of books! Found a rare edition I had been searching for. Great service and packaging.
            </p>
        </div>
        <div class="review">
            <div class="review-header">
                <span class="reviewer-name">James L.</span>
                <span class="stars">★★★★☆</span>
            </div>
            <div class="review-date">2024-01-03</div>
            <p class="review-comment">
                The book quality was excellent, and the delivery was quick. Would have given 5 stars if there were more discounts.
            </p>
        </div>
        <div class="review">
            <div class="review-header">
                <span class="reviewer-name">Olivia H.</span>
                <span class="stars">★★★★★</span>
            </div>
            <div class="review-date">2024-01-01</div>
            <p class="review-comment">
                Amazing bookstore! Their staff recommended the perfect book for my taste. Definitely my go-to store now.
            </p>
        </div>
        <div class="review">
            <div class="review-header">
                <span class="reviewer-name">Benjamin R.</span>
                <span class="stars">★★★★☆</span>
            </div>
            <div class="review-date">2023-12-30</div>
            <p class="review-comment">
                Great variety of books and friendly staff. Would love to see more book signings in the future!
            </p>
        </div>
        <div class="review">
            <div class="review-header">
                <span class="reviewer-name">Sophia T.</span>
                <span class="stars">★★★★★</span>
            </div>
            <div class="review-date">2023-12-28</div>
            <p class="review-comment">
                The best bookstore experience I've had! They had everything I needed, and the atmosphere was so cozy.
            </p>
        </div>
    </div>

    <?php require 'require/footer.html'; ?>
    <script>
        function openModal(modalId) {
            modalId.style.display = "flex";
        }

        function closeModal(modalId) {
            modalId.style.display = "none";
        }

        function submitHiddenForm() {
            document.getElementById("hiddenForm").submit();
        }
    </script>
</body>

</html>