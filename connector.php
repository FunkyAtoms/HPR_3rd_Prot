<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root"; // Default username for XAMPP
$password = "minimco"; // Default password for XAMPP (leave empty for default installation)
$dbname = "EmployeeManagement"; // The name of the database

// Create the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set the character set to UTF-8 for proper encoding
$conn->set_charset("utf8");

// Example usage
// Uncomment this line to test the connection:
// echo "Connected successfully!";
?>