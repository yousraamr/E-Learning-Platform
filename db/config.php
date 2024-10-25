<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default password for XAMPP
$database = "e-learning platform"; // Ensure this matches your database name

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

?>
 
