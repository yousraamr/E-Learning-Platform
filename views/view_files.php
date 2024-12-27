<?php
<<<<<<< HEAD
//session_start();
if ($_SESSION['user_type'] != 3) {
    header("Location: /swe_project/views/home-course.php"); 
=======
require_once(__DIR__ . '/../controllers/StudentController.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (strtolower($_SESSION['user_type']) != 'student') {
    header("Location: /swe_project/views/Home.php");
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
    exit();
}

$course = $_GET['course'] ?? 'general';
$section = $_GET['section'] ?? null;

if (!$section) {
    echo "Section not specified.";
    exit();
}
<<<<<<< HEAD

$directory = __DIR__ . "/swe_project/views/uploads/$course/$section";
$files = [];

if (is_dir($directory)) {
    $files = array_diff(scandir($directory), ['.', '..']);
}
=======
$controller = new StudentController($connection);

$files = $controller->getSectionFiles($course, $section);
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
?>

<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
=======

>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files in Section <?php echo htmlspecialchars($section); ?></title>
<<<<<<< HEAD
    <link rel="stylesheet" href="../assets/css/instructor-student-style.css"> 
    <link rel="stylesheet" href="../assets/css/Home.css"> 
=======
    <link rel="stylesheet" href="../assets/css/instructor-student-style.css">
    <link rel="stylesheet" href="../assets/css/Home.css">
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
    <style>
        .file-container {
            margin: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .file-container:hover {
            background-color: #f0f0f0;
        }

        .download-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .download-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<<<<<<< HEAD
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
        <h1><?php echo htmlspecialchars($section);  ?></h1>
=======

<body>
    <?php include 'navBar.php'; ?>

    <div class="header-courses">
        <h1>Files in Section: <?php echo htmlspecialchars($section); ?></h1>
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
    </div>

    <div class="main-cont">
        <?php if (empty($files)): ?>
            <p>No files available in this section.</p>
        <?php else: ?>
            <?php foreach ($files as $file): ?>
                <div class="file-container">
                    <p><?php echo htmlspecialchars($file); ?></p>
<<<<<<< HEAD
                    <a class="download-link" href="/../views/course/uploads/<?php echo urlencode($course) . '/' . urlencode($section) . '/' . urlencode($file); ?>" download>
                        Download
                    </a>
=======
                    <a class="download-link"
                        href="/swe_project/views/download.php?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>&file=<?php echo urlencode($file); ?>"
                        download>
                        Download
                    </a>

>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
<<<<<<< HEAD
                <img src="../assets/images/logo.png" alt="MIU Logo"> 
                <p>Misr International University<br> Established 1996</p>
            </div>
            
=======
                <img src="../assets/images/logo.png" alt="MIU Logo">
                <p>Misr International University<br> Established 1996</p>
            </div>

>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
            <div class="footer-contact">
                <h4>Contact Us</h4>
                <p>Phone: +20 123 456 789<br>Email: info@miu.edu.eg</p>
                <p>Address: 123 MIU Street, Cairo, Egypt</p>
            </div>
        </div>
<<<<<<< HEAD
        
=======

>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
        <div class="footer-bottom">
            © 2024 Misr International University - All Rights Reserved
        </div>
    </footer>
</body>
<<<<<<< HEAD
=======

>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
</html>
