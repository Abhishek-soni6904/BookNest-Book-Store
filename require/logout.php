<?php
session_start();

// Destroy all session data
session_unset();

// Destroy the session itself
session_destroy();

// Redirect to the homepage or login page
header("Location: ../index.php");
exit();
?>
