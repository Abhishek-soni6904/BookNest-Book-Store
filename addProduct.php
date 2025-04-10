<?php
require_once 'require/config.php';
if (!isset($_SESSION['CustomerID'])) {
    $_SESSION['error'] = "Please login to access this page.";
    header("Location: login.php");
    exit();
}

$bookname = "";
$description = "";
$category = "";
$author = "";
$price = "";
$image_path = "";
$book_id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Fetch existing book details if editing
if ($book_id) {
    $query = "SELECT * FROM products WHERE ProductID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $bookname = $book['ProductName'];
        $description = $book['Description'];
        $category = $book['Category'];
        $author = $book['AuthorName'];
        $price = $book['Price'];
        $image_path = $book['ImagePath'];
        $isAvailable = $book['isAvailable'];
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookname = $_POST['bookname'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $isAvailable = isset($_POST['exampleCheckbox']) ? 1 : 0;

    $target_dir = "assets/uploaded/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (!empty($_FILES["image"]["name"])) {
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types) && $_FILES["image"]["size"] <= 5 * 1024 * 1024) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                $_SESSION['error'] = "Error uploading file.";
            }
        } else {
            $_SESSION['error'] = "Invalid file format or size too large.";
        }
    }

    if ($book_id) {
        $sql = "UPDATE products SET ProductName=?, Description=?, Category=?, AuthorName=?, ImagePath=?, Price=?, isAvailable=? WHERE ProductID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssidi", $bookname, $description, $category, $author, $image_path, $price, $isAvailable, $book_id);
    } else {
        $sql = "INSERT INTO products (ProductName, Description, Category, AuthorName, ImagePath, Price) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $bookname, $description, $category, $author, $image_path, $price);
    }


    if ($stmt->execute()) {
        $_SESSION['message'] = $book_id ? "Book updated successfully!" : "Book added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: addProduct.php");
    exit();
}

$categoryResult = mysqli_query($conn, "SELECT DISTINCT Category FROM products WHERE Category IS NOT NULL AND Category != '' ORDER BY Category ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest | <?= $book_id ? 'Edit' : 'Add' ?> Book</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/nav&footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/addProduct.css">
    <link rel="stylesheet" href="css/alert.css">
</head>

<body>
    <?php require 'require/nav.php'; ?>
    <div class="container">
        <h2 class="section-title"><?= $book_id ? 'Edit' : 'Add' ?> Book</h2>
        <form action="addProduct.php<?= $book_id ? '?id=' . $book_id : '' ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="bookname">Book Name:</label>
                <input type="text" id="bookname" name="bookname" value="<?= htmlspecialchars($bookname) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($description) ?></textarea>
            </div>
           <?php 
           if($book_id): ?>
            <div class="form-group checkbox">
                <label for="isAvailable">Available:</label>
                <input type="checkbox" id="isAvailable" name="isAvailable" <?= $isAvailable ? 'checked' : '' ?>> 
            </div>
           <?php endif?>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" list="categoryList" value="<?= htmlspecialchars($category) ?>" required>
                <datalist id="categoryList">
                    <?php while ($row = mysqli_fetch_assoc($categoryResult)) : ?>
                        <option value="<?= htmlspecialchars($row['Category']) ?>"></option>
                    <?php endwhile; ?>
                </datalist>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($author) ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="1" min="1" id="price" name="price" value="<?= htmlspecialchars($price) ?>" required>
            </div>
            <div class="form-group">
                <label for="image">Book Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if ($image_path) : ?>
                    <img src="<?= htmlspecialchars($image_path) ?>" alt="Book Image" width="100">
                <?php endif; ?>
            </div>
            <button class="checkout-btn" type="submit" name="submit"><?= $book_id ? 'Update' : 'Add' ?> Book</button>
        </form>
    </div>
    <?php require 'require/footer.html'; ?>
</body>

</html>