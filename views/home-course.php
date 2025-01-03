<?php
<<<<<<< HEAD
//session_start(); // yousra commented this line as it is already active in navBar.php

$userType = $_SESSION['user_type'] ?? 3;


function getCoursePage($role) {
    return ($role == 2) ? '/swe_project/views/instructor.php' : '/swe_project/views/student.php';
}
=======
require_once(__DIR__ . '/../controllers/HomeCourseController.php');
require_once(__DIR__ . '/../db/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['user_id'] ?? null;
$userType = $_SESSION['user_type'] ?? null;

if (!$userId) {
    header("Location: register_login.php");
    exit();
}

$controller = new HomeCourseController($connection);

$courses = $controller->getCoursesForUser((int)$userId);
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Course</title>
    <link rel="stylesheet" href="../assets/css/instructor-student-style.css">
    <link rel="stylesheet" href="../assets/css/Home.css">
</head>
<body>
<<<<<<< HEAD
    <!-- Navigation Bar -->
    <?php include 'navBar.php'; ?>

<!--<header>
        <nav class="navbar">
            <div class="logo">
            <img src="..\..\assets\images\logo.png" alt="MIU Logo">
            </div>
            <ul class="nav-links">
                <li><a href=" ../../views/home/Home.php">Home</a></li>
                <li><a href="#">My courses</a></li>
                <li><a href=" ../../views/dashboard/dashboard.html">Dashboard</a></li>
                <li><a href="#">Admin</a></li>
                <li><a href=" ../../views/register_login/register_login.php" class="login">Login</a></li>
            </ul>
        </nav>
</header>-->
    <section class="main-cont">
        <div class="course-overview">

        
            <a href="<?php echo getCoursePage($userType); ?>?course=AI" class="course-card">
                <div class="course-thumbnail blue"></div>
                <h2>Artificial Intelligence I - 24F</h2>
                <p>Computer Science</p>
            </a> 

          
            <a href="<?php echo getCoursePage($userType); ?>?course=SWE" class="course-card">
                <div class="course-thumbnail blue"></div>
                <h2>Software Engineering I - 24F</h2>
                <p>Computer Science</p>
            </a>

           
            <a href="<?php echo getCoursePage($userType); ?>?course=HIS" class="course-card">
                <div class="course-thumbnail blue"></div>
                <h2>History - 24F</h2>
                <p>Computer Science</p>
            </a>

           
            <a href="<?php echo getCoursePage($userType); ?>?course=HCI" class="course-card">
                <div class="course-thumbnail light-blue"></div>
                <h2>Human Computer Interaction - 24F</h2>
                <p>Computer Science</p>
            </a>

        </div>
    </section>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="../assets/images/logo.png" alt="MIU Logo">
                <p>Misr International University<br> Established 1996</p>
            </div>

=======
    <?php include_once __DIR__ . '/navbar.php'; ?>

    <section class="main-cont">
        <div class="course-overview">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <a href="<?php echo $controller->getCoursePageUrl($userType, $course); ?>" class="course-card">
                        <div class="course-thumbnail blue"></div>
                        <h2><?php echo htmlspecialchars($course); ?></h2>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No courses available for you.</p>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <img src="../assets/images/logo.png" alt="MIU Logo"> 
                <p>Misr International University<br> Established 1996</p>
            </div>
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
            <div class="footer-contact">
                <h4>Contact Us</h4>
                <p>Phone: +20 123 456 789<br>Email: info@miu.edu.eg</p>
                <p>Address: 123 MIU Street, Cairo, Egypt</p>
            </div>
<<<<<<< HEAD

            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Campus Map</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Admission Process</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-social">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

=======
        </div>
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
        <div class="footer-bottom">
            © 2024 Misr International University - All Rights Reserved
        </div>
    </footer>
</body>
</html>
