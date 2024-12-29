<?php
require_once(__DIR__ . '/../controllers/StudentController.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (strtolower($_SESSION['user_type']) != 'student') {
    header("Location: /swe_project/views/Home.php");
    exit();
}

$course = $_GET['course'] ?? 'general';
$section = $_GET['section'] ?? null;

if (!$section) {
    echo "Section not specified.";
    exit();
}
$controller = new StudentController($connection);

$files = $controller->getSectionFiles($course, $section);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files in Section <?php echo htmlspecialchars($section); ?></title>
    <link rel="stylesheet" href="../assets/css/instructor-student-style.css">
    <link rel="stylesheet" href="../assets/css/Home.css">
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

<body>
    <?php include 'navBar.php'; ?>

    <div class="header-courses">
        <h1>Files in Section: <?php echo htmlspecialchars($section); ?></h1>
    </div>

    <div class="main-cont">
        <?php if (empty($files)): ?>
            <p>No files available in this section.</p>
        <?php else: ?>
            <?php foreach ($files as $file): ?>
                <div class="file-container">
                    <p><?php echo htmlspecialchars($file); ?></p>
                    <a class="download-link"
                        href="/swe_project/views/download.php?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>&file=<?php echo urlencode($file); ?>"
                        download>
                        Download
                    </a>

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
