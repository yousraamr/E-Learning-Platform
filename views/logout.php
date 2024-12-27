<?php
include_once __DIR__ . "/../models/User.php";

session_start();
$user = new User($connection); 
$user->logout(); 

header("Location: /swe_project/views/register_login.php");
exit();
?>