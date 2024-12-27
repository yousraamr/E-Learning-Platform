<?php
include_once __DIR__ . '/../db/config.php';
include_once __DIR__ . '/../models/User.php';
include_once __DIR__ . '/../controllers/instructorController.php';

$section = $_GET['section'] ?? 'unknown';
$course = $_GET['course'] ?? 'unknown';


$user = new User($connection);


if (isset($_GET['download'])) {
    $user->downloadFile();
    exit;
}


$courseQuery = mysqli_prepare($connection, "SELECT id FROM user_courses WHERE course_name = ?");
mysqli_stmt_bind_param($courseQuery, "s", $course);
mysqli_stmt_execute($courseQuery);
$courseResult = mysqli_stmt_get_result($courseQuery);
$courseData = mysqli_fetch_assoc($courseResult);

$sectionQuery = mysqli_prepare($connection, "SELECT id FROM course_sections WHERE section_name = ? AND course_name = ?");
mysqli_stmt_bind_param($sectionQuery, "ss", $section, $course);
mysqli_stmt_execute($sectionQuery);
$sectionResult = mysqli_stmt_get_result($sectionQuery);
$sectionData = mysqli_fetch_assoc($sectionResult);

if (!$courseData || !$sectionData) {
    die("Error: Invalid course or section.");
}

$courseId = $courseData['id'];
$sectionId = $sectionData['id'];
$baseDirectory = __DIR__ . "/../views/uploads"; 
$directory = "$baseDirectory/$course/$section"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['lecture_file'])) {
    $instructorController = new InstructorController($connection);
    $message = $instructorController->uploadLecture($courseId, $sectionId, $_FILES['lecture_file'], $directory);
}

if (isset($_GET['delete'])) {
    $instructorController = new InstructorController($connection);
    $message = $instructorController->deleteLecture($courseId, $sectionId, $_GET['delete'], $directory);
}


$filesQuery = mysqli_prepare($connection, "SELECT u.file_name FROM uploads u
    INNER JOIN user_courses c ON u.course_id = c.id
    INNER JOIN course_sections s ON u.section_id = s.id
    WHERE u.course_id = ? AND u.section_id = ?");
mysqli_stmt_bind_param($filesQuery, "ii", $courseId, $sectionId);
mysqli_stmt_execute($filesQuery);
$uploadedFilesResult = mysqli_stmt_get_result($filesQuery);
$uploadedFiles = mysqli_fetch_all($uploadedFilesResult, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Lectures for <?php echo htmlspecialchars($section); ?> - <?php echo htmlspecialchars($course); ?></title>
    <link rel="stylesheet" href="../assets/css/instructor-student-style.css">
    <link rel="stylesheet" href="../assets/css/Home.css">
</head>
<body>
    <?php include 'navBar.php'; ?>

    <div class="header-courses">
        <h1>Upload for <?php echo htmlspecialchars($section); ?></h1>
    </div>

    <div class="main-cont">
        

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="lecture_file" required>
            <button type="submit" class="btn">Upload</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($uploadedFiles)): ?>
                    <tr>
                        <td colspan="2">No files uploaded yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($uploadedFiles as $file): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file['file_name']); ?></td>
                            <td>
                            <a href="?download=1&file=<?php echo urlencode($file['file_name']); ?>&course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>">Download</a>
                            <a href="?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>&delete=<?php echo urlencode($file['file_name']); ?>" class="delete-btn2">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
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
