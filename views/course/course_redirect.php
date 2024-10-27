<?php
session_start(); // Start session to access user type

if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: register_login.php");
    exit();
}

$user_type = $_SESSION['user_type']; // Get user type from session
$course_id = $_GET['course_id']; // Get selected course ID

// Redirect based on user type
if ($user_type == 2) {
    // Instructor redirects to upload.php
    header("Location: instructor.php?course_id=$course_id");
} elseif ($user_type == 3) {
    // Student redirects to student.php
    header("Location: student.php?course_id=$course_id");
} else {
    // Admin or unknown user type goes to dashboard.php
    header("Location: dashboard.php");
}

exit();
?>
