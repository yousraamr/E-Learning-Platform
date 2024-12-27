<?php
<<<<<<< HEAD
// Prevent caching issues
header("Cache-Control: no-cache, must-revalidate");


$course = $_GET['course'] ?? 'general';
$section = $_GET['section'] ?? 'unknown';


if ($section === 'quiz') {
    header("Location: quiz.php?course=$course");
    exit;
}
if ($section === 'assignment') {
    header("Location: assignment.php?course=$course");
=======
include_once __DIR__ . '/../db/config.php';
include_once __DIR__ . '/../models/User.php';
include_once __DIR__ . '/../controllers/instructorController.php';

$section = $_GET['section'] ?? 'unknown';
$course = $_GET['course'] ?? 'unknown';


$user = new User($connection);


if (isset($_GET['download'])) {
    $user->downloadFile();
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
    exit;
}


<<<<<<< HEAD
$directory = __DIR__ . "/swe_project/views/uploads/$course/$section"; 


if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

$message = ''; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['lecture_file'])) {
    $fileName = basename($_FILES['lecture_file']['name']);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedTypes = ['pdf', 'ppt', 'pptx', 'docx']; // Add more types as needed

    if (in_array($fileType, $allowedTypes)) {
        $targetFilePath = $directory . '/' . uniqid() . "_" . $fileName; // Use unique filename

        if (move_uploaded_file($_FILES['lecture_file']['tmp_name'], $targetFilePath)) {
            $message = "File uploaded successfully!";
        } else {
            $message = "Error: Unable to upload the file.";
        }
    } else {
        $message = "Error: Invalid file type.";
    }
}


if (isset($_GET['delete'])) {
    $fileToDelete = $directory . '/' . $_GET['delete'];
    if (file_exists($fileToDelete) && unlink($fileToDelete)) {
        $message = "File deleted successfully!";
    } else {
        $message = "Error: Unable to delete the file.";
    }
}


$uploadedFiles = array_filter(
    array_diff(scandir($directory), ['.', '..']),
    fn($file) => !str_starts_with($file, '.') && $file !== 'sections.json'
);
?>

=======
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


>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Lectures for <?php echo htmlspecialchars($section); ?> - <?php echo htmlspecialchars($course); ?></title>
<<<<<<< HEAD

 
=======
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
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
        <h1>Upload for <?php echo htmlspecialchars($section);  ?></h1>
    </div>

    <div class="main-cont">
        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
=======
    <?php include 'navBar.php'; ?>

    <div class="header-courses">
        <h1>Upload for <?php echo htmlspecialchars($section); ?></h1>
    </div>

    <div class="main-cont">
        
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff

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
<<<<<<< HEAD
                            <td><?php echo htmlspecialchars($file); ?></td>
                            <td>
                                <a href="<?php echo "../../uploads/$course/$section/" . htmlspecialchars($file); ?>" download>Download</a> 
                                <a href="?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>&delete=<?php echo urlencode($file); ?>" class="delete-btn2">Delete</a>
=======
                            <td><?php echo htmlspecialchars($file['file_name']); ?></td>
                            <td>
                            <a href="?download=1&file=<?php echo urlencode($file['file_name']); ?>&course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>">Download</a>
                            <a href="?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>&delete=<?php echo urlencode($file['file_name']); ?>" class="delete-btn2">Delete</a>
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
<<<<<<< HEAD

        <form method="GET" action="">
            <input type="hidden" name="course" value="<?php echo htmlspecialchars($course); ?>">
            <input type="hidden" name="section" value="<?php echo htmlspecialchars($section); ?>">
            <button type="submit" name="delete_section" class="btn delete-btn2">Delete Section</button>
        </form>
=======
>>>>>>> 05e937ed01a572bf03bcd649485c169a158eaeff
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
