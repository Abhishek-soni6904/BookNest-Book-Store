<?php
require_once 'config.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'login':
            // Login logic
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $stmt = mysqli_prepare($conn, "SELECT * FROM customer WHERE Email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                if (password_verify($password, $user['Password'])) {
                    $_SESSION['CustomerID'] = $user['CustomerID'];
                    $_SESSION['Email'] = $user['Email'];
                    $_SESSION['FullName'] = $user['FullName'];

                      $_SESSION['message'] = "Login successful!";
                    header("Location: index.php");
                    exit();
                }
            }
            $_SESSION['error'] = "Invalid email or password!";
            break;

        case 'register':
            // Registration logic
            $fullName = trim($_POST['fullName']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Check if email already exists
            $stmt = mysqli_prepare($conn, "SELECT CustomerID FROM customer WHERE Email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $_SESSION['error'] = "Email already registered!";
                break;
            }

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new customer
            $stmt = mysqli_prepare($conn, "INSERT INTO customer (FullName, Email, Password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['CustomerID'] = mysqli_insert_id($conn);
                $_SESSION['Email'] = $email;
                $_SESSION['FullName'] = $fullName;

                $_SESSION['message'] = "Registration successful!";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed! Please try again.";
            }
            break;

        default:
            $_SESSION['error'] = "Invalid action!";
            break;
    }

    // Redirect to the same page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
