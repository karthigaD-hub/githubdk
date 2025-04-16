<?php
$host = 'localhost';
$username = 'root';
$password = 'karz@2005'; // Update as per your MySQL setup
$dbname = 'food_tracking';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
