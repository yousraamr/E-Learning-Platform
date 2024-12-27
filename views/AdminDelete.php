<?php
require_once('../models/AdminModel.php');
require_once(__DIR__ . '/../controllers/AdminController.php');

$servername = "localhost";
$username = "root";
$password = "";
$database = "e-learning platform";

$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}



// Instantiate the Admin object
$admin = new Admin($connection);

// Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Get the user ID from the URL

    $result = $admin->deleteUser($user_id);

    if ($result === "User deleted successfully!") {

        header("Location: Admin.php?message=User deleted successfully");
        exit;
    } else {
        echo "Error deleting user: " . $result;
    }
} else {
    echo "Invalid user ID";
}

$connection->close();
?>
