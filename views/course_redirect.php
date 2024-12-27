<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
   
    header("Location: register_login.php");
    exit();
}

$user_type = $_SESSION['user_type']; 



if ($user_type == 2) {
   
    header("Location: instructor.php");
} elseif ($user_type == 3) {
   
    header("Location: student.php");
} else {
    
    header("Location: dashboard.php");
}

exit();
?>
