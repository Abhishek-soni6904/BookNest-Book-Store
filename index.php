<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest | Your Haven for Books</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/alert.css">
    <link rel="stylesheet" href="css/nav&footer.css">
</head>

<body>
    <?php
    require 'require/config.php';
    require 'require/nav.php';

    $categoryResult = mysqli_query($conn, "SELECT DISTINCT Category FROM products WHERE Category IS NOT NULL AND Category != '' ORDER BY Category ASC");
    $AuthorResult = mysqli_query($conn, "SELECT DISTINCT AuthorName FROM products WHERE AuthorName IS NOT NULL AND AuthorName != '' ORDER BY AuthorName ASC");
    if (!$categoryResult || !$AuthorResult) die("Database query failed: " . mysqli_error($conn));

    $categoryIcons = array(
        "Biography and Autobiography" => "fas fa-user",
        "Comics" => "fas fa-mask",
        "Fantasy" => "fas fa-dragon",
        "Mystery and Thriller" => "fas fa-user-secret",
        "Philosophy" => "fas fa-brain",
        "Horror" => "fas fa-ghost"
    );
    ?>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Discover Your Next Great Read</h1>
                <p class="hero-subtitle">Explore a world of stories, knowledge, and inspiration</p>
                <div class="hero-cta">
                    <a href="AllProduct.php" class="primary-btn">Shop Now</a>
                    <a href="#footer" class="secondary-btn">Contact Us</a>
                </div>
            </div>
        </section>

        <section class="categories">
            <h2 class="section-title">Explore by Category</h2>
            <div class="category-grid">
                <?php while ($category = mysqli_fetch_assoc($categoryResult)) : ?>
                    <a href="Allproduct.php?category=<?= urlencode($category['Category']) ?>">
                        <div class="category-card">
                        <i class="category-icon <?= $categoryIcons[htmlspecialchars($category['Category'])] ?? "fas fa-book-open" ?>"></i>
                            <h3><?= strtoupper(htmlspecialchars($category['Category'])) ?></h3>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </section>

        <section class="authors-section">
            <h2 class="section-title">Authors</h2>
            <div class="authors-wrapper">
                <div class="authors-scroll">
                    <?php while ($Author = mysqli_fetch_assoc($AuthorResult)) : ?>
                        <div class="author-card">
                            <a href="Allproduct.php?author=<?= urlencode($Author['AuthorName']) ?>">
                                <h3><?= htmlspecialchars($Author['AuthorName']) ?></h3>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="authors-scroll" aria-hidden="true">
                    <?php
                    mysqli_data_seek($AuthorResult, 0);
                    while ($Author = mysqli_fetch_assoc($AuthorResult)) : ?>
                        <div class="author-card">
                            <a href="Allproduct.php?author=<?= urlencode($Author['AuthorName']) ?>">
                                <h3><?= htmlspecialchars($Author['AuthorName']) ?></h3>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>

        <section class="featured-products">
            <h2 class="section-title">Featured Products</h2>
            <div id="controls">
                <div class="prev"><i class="fas fa-angle-left"></i></div>
                <div class="next"><i class="fas fa-angle-right"></i></div>
            </div>
            <div class="product-slider">
                <?php
                $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 10";
                $result = mysqli_query($conn, $sql);
                ?>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?= htmlspecialchars($row['ImagePath']) ?>" alt="<?= htmlspecialchars($row['ProductName']) ?>">
                            </div>
                            <div class="product-info">
                                <h3><?= htmlspecialchars($row['ProductName']) ?></h3>
                                <p class="product-category"> <?= htmlspecialchars($row['Category']) ?></p>
                                <span class="current-price">₹<?= htmlspecialchars($row['Price']) ?></span>
                                <button id="<?= $row['ProductID'] ?>" class="view-product">View Product</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>
    <?php require 'require/footer.html'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script src="js/index.js"></script>
</body>

</html>