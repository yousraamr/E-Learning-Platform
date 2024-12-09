<?php
//session_start();
if ($_SESSION['user_type'] != 2) {
    header("Location: ../Home-course.php"); 
    exit();
}


header("Cache-Control: no-cache, must-revalidate");

$course = $_GET['course'] ?? 'general';
$directory = "/swe_project/views/uploads/$course";
$sectionsFile = "$directory/sections.json";

//if not exist
if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}


$sections = [];
if (is_file($sectionsFile)) {
    $sections = json_decode(file_get_contents($sectionsFile), true) ?? [];
    if (!is_array($sections)) $sections = [];
}

$message = ''; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSection = trim($_POST['section_name'] ?? '');
    if ($newSection !== '') {
        $sections[] = $newSection;
        if (file_put_contents($sectionsFile, json_encode($sections))) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?course=" . urlencode($course) . "&message=success");
            exit();
        } else {
            $message = "Error: Unable to save the new section.";
        }
    } else {
        $message = "Section name cannot be empty.";
    }
}


if (isset($_GET['delete'])) {
    $deleteIndex = (int)$_GET['delete'];
    if (isset($sections[$deleteIndex])) {
        unset($sections[$deleteIndex]);
        $sections = array_values($sections); // Re-index
        file_put_contents($sectionsFile, json_encode($sections));
        header("Location: " . $_SERVER['PHP_SELF'] . "?course=" . urlencode($course) . "&message=deleted");
        exit();
    }
}


if (isset($_GET['message'])) {
    if ($_GET['message'] === 'success') {
        $message = "Section added successfully!";
    } elseif ($_GET['message'] === 'deleted') {
        $message = "Section deleted successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Panel</title>
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
                <li><a href=" ../../views/home/Home.php">Home</a></li>
                <li><a href=" ../../views/course/home-course.php">My courses</a></li>
                <li><a href=" ../../views/dashboard/dashboard.html">Dashboard</a></li>
            </ul>
        </nav>
    </header>-->

    <div class="header-courses">
        <h1><?php echo htmlspecialchars($course); ?> </h1>
        <div class="breadcrumb">
            <a href="../home.php">Home</a> > <?php echo htmlspecialchars($course); ?> Sections
        </div>
    </div>

    <div class="main-cont">
        <?php if ($message): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form class="form-container" method="POST">
            <input type="text" name="section_name" placeholder="Enter section name" required>
            <button type="submit" class="btn">Add Section</button>
        </form>

        <div class="card-grid">
            <?php if (empty($sections)): ?>
                <p>No sections added yet.</p>
            <?php else: ?>
                <?php foreach ($sections as $index => $section): ?>
                    <div class="card">
                        <?php 
                        $targetPage = match ($section) {
                            'quiz' => '../quiz.php',
                            'assignment' => '../assignment.php',
                            default => '/swe_project/views/upload.php',
                        };
                        ?>
                        <div 
                            class="card-content" 
                            onclick="location.href='<?php echo $targetPage; ?>?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section); ?>';"
                            style="cursor: pointer;"
                        >
                            <h3><?php echo htmlspecialchars($section); ?></h3>
                        </div>
                        <button class="delete-btn" onclick="location.href='?course=<?php echo urlencode($course); ?>&delete=<?php echo $index; ?>';">&times;</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
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
