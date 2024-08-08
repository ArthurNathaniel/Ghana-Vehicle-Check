<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ghana_vehicle_check";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
