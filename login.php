<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>BookNest | Account Access</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/alert.css">
</head>

<body>
    <?php
    require 'require/loginBack.php';
    if (isset($_SESSION['message'])) {
        echo '<div class=" message alert-item success"><i class="fas fa-check"></i>' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="message alert-item failure "><i class="fas fa-ban"></i>' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>
    <div class="container">
        <div class="logo">
            <i class="fas fa-book fa-2x"></i>
            <h1 class="logo-text">BookNest</h1>
        </div>
        <p class="welcome-text">Welcome back</p>
        <p class="subtitle">Please enter your details to continue</p>

        <div class="tabs">
            <div class="tab active" data-tab="login">Login</div>
            <div class="tab" data-tab="register">Register</div>
        </div>

        <div class="form-container">
            <form class="form active" id="loginForm" method="post">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input name="email" type="email" id="loginEmail" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input name="password" type="password" id="loginPassword" placeholder="Enter your password" required>
                </div>
                <button type="submit">Sign in</button>
            </form>

            <form class="form" id="registerForm" method="post">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="registerName">Full Name</label>
                    <input type="text" name="fullName" id="registerName" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email</label>
                    <input type="email" name="email" id="registerEmail" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <input type="password" name="password" id="registerPassword" placeholder="Create a password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" placeholder="Confirm your password" required>
                    <div id="matchMessage">Passwords do not match</div>
                </div>
                <button id="registerSubmit" type="submit">Create account</button>
            </form>
        </div>
    </div>
    <script src="js/login.js"></script>
</body>

</html>