<?php
$redirectUrl = $_SERVER['PHP_SELF'];
if (isset($_GET['id'])) {
    $redirectUrl = $_SERVER['PHP_SELF'] . '?id=' . $_GET['id'];
}
// Process form submissions for updating details or password
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['fullName']) || isset($_POST['email']) || isset($_POST['phone'])) {
        // Update details
        $fullName = !empty($_POST['fullName']) ? $_POST['fullName'] : $custDetails['FullName'];
        $email = !empty($_POST['email']) ? $_POST['email'] : $custDetails['Email'];
        $phone = !empty($_POST['phone']) ? $_POST['phone'] : $custDetails['PhoneNumber'];

        // Validate inputs
        if ($fullName && $email) {
            $query = "UPDATE customer SET FullName = ?, Email = ?, PhoneNumber = ? WHERE CustomerID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssi", $fullName, $email, $phone, $_SESSION['CustomerID']);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Details updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update details!";
            }
            header("Location: " . $redirectUrl);
            exit;
        } else {
            $_SESSION['error'] = "Please provide valid details!";
            header("Location: " . $redirectUrl);
            exit;
        }
    } elseif (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
        // Update password
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Validate passwords
        if ($newPassword === $confirmPassword) {
            // Check current password
            $query = "SELECT Password FROM customer WHERE CustomerID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['CustomerID']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            if (password_verify($currentPassword, $user['Password'])) {
                // Update password
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $query = "UPDATE customer SET Password = ? WHERE CustomerID = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $_SESSION['CustomerID']);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['message'] = "Password updated successfully!";
                } else {
                    $_SESSION['error'] = "Failed to update password!";
                }
                header("Location: " . $redirectUrl);
                exit;
            } else {
                $_SESSION['error'] = "Current password is incorrect!";
                header("Location: " . $redirectUrl);
                exit;
            }
        } else {
            $_SESSION['error'] = "New passwords do not match!";
            header("Location: " . $redirectUrl);
            exit;
        }
    }
}
?>

<nav class="navbar">
    <div class="nav-content">
        <div class="logo">
            <i class="fas fa-book"></i>
            <span class="logo-text">BookNest</span>
        </div>
        <div class="nav-actions">
            <a href="index.php" class="nav-link">
                <i class="fas fa-home nav-icon"></i>
                <span>Home</span>
            </a>
            <?php
            $isLoggedIn = isset($_SESSION['CustomerID']);
            if ($isLoggedIn) {
                $query = "SELECT quantity FROM cart WHERE CustomerID = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $_SESSION['CustomerID']);
                mysqli_stmt_execute($stmt);
                $cart_result = mysqli_stmt_get_result($stmt);
                $cart_count = mysqli_num_rows($cart_result);
                $query = "SELECT * FROM customer WHERE CustomerID = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $_SESSION['CustomerID']);
                mysqli_stmt_execute($stmt);
                $user_result = mysqli_stmt_get_result($stmt);
                $custDetails = mysqli_fetch_assoc($user_result);
            ?>
                <span href="/account" class="nav-link">
                    <i class="fas fa-user nav-icon"></i>
                    <span>Actions</span>
                    <div class="hover-block">
                        <?php if($custDetails['type']):?>
                        <button onclick="window.location.href='addProduct.php';" class="btn">Add Product</button>
                        <?php endif;?>
                        <button onclick="openModal(updateDetailsModal)" class="btn">Update Details</button>
                        <button onclick="openModal(updatePasswordModal)" class="btn">Update Password</button>
                    </div>
                </span>
                <a href="orders.php" class="nav-link">
                    <i class="fas fa-box nav-icon"></i>
                    <span>Orders</span>
                </a>
                <a href="cart.php" class="nav-link cart-link">
                    <i class="fas fa-shopping-cart nav-icon"></i>
                    <span>Cart</span>
                    <span class="cart-count"><?php echo $cart_count; ?></span>
                </a>
                <a href="require/logout.php" class="nav-link">
                    <i class="fas fa-right-from-bracket nav-icon"></i>
                    <span>Logout</span>
                </a>
            <?php
            } else {
            ?>
                <a href="login.php" class="nav-link"><i class="fas fa-sign-in-alt nav-icon"></i><span>Login</span></a>
                <a href="login.php" class="nav-link cart-link"><i class="fas fa-shopping-cart nav-icon"></i><span>Cart</span><span class="cart-count">0</span></a>
            <?php
            }

            if (isset($_SESSION['message'])) {
                echo '<div class=" message alert-item success"><i class="fas fa-check"></i>' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            }

            if (isset($_SESSION['error'])) {
                echo '<div class="message alert-item failure "><i class="fas fa-ban"></i>' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>

    <!-- Update Details Modal -->
    <div id="updateDetailsModal" class="modal">
        <div class="modal-content">
            <h2>Update Details</h2>
            <form id="updateDetailsForm" method="post">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" required
                        <?php echo 'value="' . htmlspecialchars($custDetails['FullName'] ?? '') . '"'; ?> />
                </div>
                <div class="form-group">
                    <label for="updateEmail">Email</label>
                    <input type="email" id="updateEmail" name="email" required
                        <?php echo 'value="' . htmlspecialchars($custDetails['Email'] ?? '') . '"'; ?> />
                </div>
                <div class="form-group">
                    <label for="updatePhone">Phone</label>
                    <input type="tel" id="updatePhone" name="phone"
                        <?php echo 'value="' . htmlspecialchars($custDetails['PhoneNumber'] ?? '') . '"'; ?> />
                </div>
                <button type="submit" class="checkout-btn">Update Details</button>
                <button type="button" onclick="closeModal(updateDetailsModal)" class="delete-btn">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Update Password Modal -->
    <div id="updatePasswordModal" class="modal">
        <div class="modal-content">
            <h2>Update Password</h2>
            <form id="updatePasswordForm" method="post">
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" id="currentPassword" name="currentPassword" required>
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" id="newPassword" name="newPassword" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <button type="submit" class="checkout-btn">Update Password</button>
                <button type="button" onclick="closeModal(updatePasswordModal)" class="delete-btn">Cancel</button>
            </form>
        </div>
    </div>
</nav>