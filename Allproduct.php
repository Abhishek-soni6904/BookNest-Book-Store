<?php
// Fetch products from database
require 'require/config.php';
$query = "SELECT * FROM products ORDER BY ProductName ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
// Query to fetch distinct categories
$categoryQuery = "SELECT DISTINCT Category FROM products WHERE Category IS NOT NULL AND Category != '' ORDER BY Category ASC";
$categoryResult = mysqli_query($conn, $categoryQuery);

// Query to fetch distinct author names
$authorQuery = "SELECT DISTINCT AuthorName FROM products WHERE AuthorName IS NOT NULL AND AuthorName != '' ORDER BY AuthorName ASC";
$authorResult = mysqli_query($conn, $authorQuery);

if (!$categoryResult || !$authorResult) {
    die("Database query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest | Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/allProduct.css">
    <link rel="stylesheet" href="css/nav&footer.css">
    <link rel="stylesheet" href="css/alert.css">
</head>

<body>
    <?php
    require 'require/nav.php';
    $selectedCategory = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';
    $selectedAuthor = isset($_GET['author']) ? htmlspecialchars($_GET['author']) : '';
    ?>
    <div class="search-wrapper">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="Search books by title, author, or category...">
        </div>
    </div>
    <section class="products-section">
        <h2 class="section-title">Our Products</h2>

        <div class="filters">
            <!-- Category Filter -->
            <select class="filter-select" id="categoryFilter">
                <option value="">All Categories</option>
                <?php while ($category = mysqli_fetch_assoc($categoryResult)) { ?>
                    <option value="<?php echo htmlspecialchars($category['Category']); ?>"
                        <?php echo ($selectedCategory === $category['Category']) ? 'selected' : ''; ?>>
                        <?php echo ucwords(htmlspecialchars($category['Category'])); ?>
                    </option>
                <?php } ?>
            </select>

            <!-- author Name Filter -->
            <select class="filter-select" id="authorFilter">
                <option value="">All authors</option>
                <?php while ($author = mysqli_fetch_assoc($authorResult)) { ?>
                    <option value="<?php echo htmlspecialchars($author['AuthorName']); ?>"
                        <?php echo ($selectedAuthor === $author['AuthorName']) ? 'selected' : ''; ?>>
                        <?php echo ucwords(htmlspecialchars($author['AuthorName'])); ?>
                    </option>
                <?php } ?>
            </select>

            <select class="filter-select" id="sortFilter">
                <option value="name-asc">Name: A to Z</option>
                <option value="name-desc">Name: Z to A</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
            </select>
        </div>

        <div class="products-grid">
            <?php while ($product = mysqli_fetch_assoc($result)) { ?>
                <div class="product-card" data-category="<?php echo htmlspecialchars($product['Category']); ?>" data-author="<?php echo htmlspecialchars($product['AuthorName']); ?>">
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($product['ImagePath']); ?>"
                            alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?php echo htmlspecialchars($product['Category']); ?></div>
                        <h3 class="product-name"><?php echo ucwords(htmlspecialchars($product['ProductName'])); ?></h3>
                        <p class="product-description">
                            <?php
                            echo implode(' ', array_slice(explode(' ', htmlspecialchars($product['Description'])), 0, 20)) . '...';
                            ?>
                        </p>
                        <div class="flex">
                            <div class="current-price">₹<?php echo number_format($product['Price'], 2); ?></div>
                            <div class="<?php echo ($product['isAvailable']) ? 'inStock' : 'outStock'; ?>">
                                <?php echo ($product['isAvailable']) ? 'In Stock' : 'Out of Stock'; ?>
                            </div>
                        </div>
                        <button id="<?php echo $product['ProductID']; ?>" class="view-product">View Details</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php require 'require/footer.html'; ?>
    <script src="js/Allproduct.js"></script>
</body>

</html>