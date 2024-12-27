<?php
//session_start();
if ($_SESSION['user_type'] != 3) {
    header("Location: /swe_project/views/home-course.php"); 
    exit();
}

header("Cache-Control: no-cache, must-revalidate");

$course = $_GET['course'] ?? 'general';
$directory = __DIR__ . "/swe_project/views/uploads/$course"; 
$sectionsFile = "$directory/sections.json";

$sections = [];
if (is_file($sectionsFile)) {
    $sections = json_decode(file_get_contents($sectionsFile), true) ?? [];
    if (!is_array($sections)) $sections = [];
}
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
    <!-- Navigation Bar -->
    <?php include 'navBar.php'; ?>

    <!--<header>
        <nav class="navbar">
            <div class="logo">
                <img src="../../assets/images/logo.png" alt="MIU Logo"> 
            </div>
            <ul class="nav-links">
                <li><a href="../../home/Home.php">Home</a></li>
                <li><a href="../course/home-course.php">My Courses</a></li> 
                <li><a href="#">Dashboard</a></li>
            </ul>
        </nav>
    </header>-->

    <div class="header-courses">
        <h1>Available Sections for <?php echo htmlspecialchars($course); ?></h1>
    </div>

    <div class="main-cont">
        <?php if (empty($sections)): ?>
            <p>No sections found for this course.</p>
        <?php else: ?>
            <?php foreach ($sections as $section): ?>
                <div class="section-container" 
                     onclick="location.href='view_files.php?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>';">
                    <h2><?php echo htmlspecialchars($section); ?></h2>
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
