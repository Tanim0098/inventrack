<?php
// Database configuration
$servername = "localhost";     // Usually localhost
$username = "root";            // Your database username
$password = "";                // Your database password (empty for XAMPP/WAMP)
$dbname = "web_inventory"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");
?>