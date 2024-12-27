<?php
include_once __DIR__ . '/../db/config.php';
include_once __DIR__ . '/../models/User.php'; 



$user = new User($connection);
$user->downloadFile();
?>
