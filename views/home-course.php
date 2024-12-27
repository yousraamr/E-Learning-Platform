<?php
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
            <div class="footer-contact">
                <h4>Contact Us</h4>
                <p>Phone: +20 123 456 789<br>Email: info@miu.edu.eg</p>
                <p>Address: 123 MIU Street, Cairo, Egypt</p>
            </div>
        </div>
        <div class="footer-bottom">
            © 2024 Misr International University - All Rights Reserved
        </div>
    </footer>
</body>
</html>
