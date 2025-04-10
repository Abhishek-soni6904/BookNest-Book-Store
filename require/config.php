<?php
// Database connection
$host = 'localhost';
$username = 'root';  
$password = '';      
$database = 'bookstore';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
?>
