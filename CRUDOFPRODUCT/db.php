<?php
// Database connection settings
$host = 'localhost';     // Hostname (usually localhost)
$dbname = 'product_management'; // Database name
$username = 'root';       // Database username (default is 'root' for XAMPP/WAMP)
$password = '';           // Database password (leave blank for XAMPP/WAMP)

// Establish a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

