<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (strtolower($_SESSION['user_type']) != 'student') {
    header("Location: /swe_project/views/Home.php"); 
    exit();
}

include_once __DIR__ . '/../controllers/StudentController.php';
include_once __DIR__ . '/../db/config.php'; 

$course = $_GET['course'] ?? 'general';
if (empty($course)) {
    die("Invalid course.");
}


$StudentController = new StudentController($connection); 

$studentId = $_SESSION['user_id'];


$sections = $StudentController->getSections($course);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student - View Sections for <?php echo htmlspecialchars($course); ?></title>
    <link rel="stylesheet" href="../assets/css/instructor-student-style.css"> 
    <link rel="stylesheet" href="../assets/css/Home.css"> 
    <style>
        .section-container {
            margin: 10px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .section-container:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <?php include 'navBar.php'; ?>

    <div class="header-courses">
        <h1>Available Sections for <?php echo htmlspecialchars($course); ?></h1>
    </div>

    <div class="main-cont">
        <?php if (empty($sections)): ?>
            <p>No sections found for this course.</p>
        <?php else: ?>
            <?php foreach ($sections as $section): ?>
                <div class="section-container" 
                     onclick="location.href='view_files.php?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section['section_name']); ?>';">
                    <h2><?php echo htmlspecialchars($section['section_name']); ?></h2>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

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
