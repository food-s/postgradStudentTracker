<?php

$host = 'localhost';
$username = 'root';  // Assuming you are using the default root user
$password = '';      // If you set a password for the root user, enter it here
$database = 'postgrad_dashboard';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
