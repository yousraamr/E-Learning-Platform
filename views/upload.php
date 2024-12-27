<?php
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
    exit;
}


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
                            <td><?php echo htmlspecialchars($file); ?></td>
                            <td>
                                <a href="<?php echo "../../uploads/$course/$section/" . htmlspecialchars($file); ?>" download>Download</a> 
                                <a href="?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>&delete=<?php echo urlencode($file); ?>" class="delete-btn2">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <form method="GET" action="">
            <input type="hidden" name="course" value="<?php echo htmlspecialchars($course); ?>">
            <input type="hidden" name="section" value="<?php echo htmlspecialchars($section); ?>">
            <button type="submit" name="delete_section" class="btn delete-btn2">Delete Section</button>
        </form>
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

        <div class="footer-bottom">
            © 2024 Misr International University - All Rights Reserved
        </div>
    </footer>
</body>
</html>
