<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "calendar-app";

// Create connection (using XAMPP or MAMPP stack for local development environment)
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4"); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}