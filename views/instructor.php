<?php

include_once __DIR__ . '/../commands/Command.php';
include_once __DIR__ . '/../commands/CommandInvoker.php';
include_once __DIR__ . '/../commands/FetchSectionsCommand.php';
include_once __DIR__ . '/../commands/AddSectionCommand.php';
include_once __DIR__ . '/../commands/DeleteSectionCommand.php';
include_once __DIR__ . '/../controllers/instructorController.php';


session_start();


if (!isset($_SESSION['user_type']) || strtolower($_SESSION['user_type']) !== 'instructor') {
    header("Location: /swe_project/views/Home.php");
    exit();
}


$course = $_GET['course'] ?? 'general';


$instructorId = $_SESSION['user_id'] ?? null;
if (!$instructorId) {
    header("Location: /swe_project/views/register_login.php");
    exit();
}

$message = '';
$sections = [];

try {
    $instructorController = new InstructorController($connection);
    $invoker = new CommandInvoker();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include_once __DIR__ . '/../commands/AddSectionCommand.php';
        $sectionName = trim($_POST['section_name'] ?? '');
        if (!empty($sectionName)) {
            $command = new AddSectionCommand($instructorController, $instructorId, $course, $sectionName);
            $message = $invoker->execute($command);
            header("Location: ?course=" . urlencode($course) . "&message=success");
            exit();
        } else {
            $message = "Section name cannot be empty.";
        }
    }

    if (isset($_GET['delete'])) {
        $sectionId = (int)$_GET['delete'];
        $command = new DeleteSectionCommand($instructorController, $instructorId, $sectionId, $course);
        $message = $invoker->execute($command);
        header("Location: ?course=" . urlencode($course) . "&message=deleted");
        exit();
    }

  
    $command = new FetchSectionsCommand($instructorController, $instructorId, $course);
    $sections = $invoker->execute($command);
} catch (Exception $e) {
    $message = $e->getMessage();
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
    <?php include 'navBar.php'; ?>

    <div class="header-courses">
        <h1><?php echo htmlspecialchars($course); ?> Sections</h1>
        <div class="breadcrumb">
            <a href="../home.php">Home</a> > <?php echo htmlspecialchars($course); ?> Sections
        </div>
    </div>

    <div class="main-cont">
        <?php if (!empty($message)): ?>
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
                <?php foreach ($sections as $section): ?>
                    <div class="card">
                        <?php
                        $targetPage = match (strtolower($section['section_name'])) {
                            'quiz' => '../quiz.php',
                            'assignment' => '../assignment.php',
                            default => '/swe_project/views/upload.php',
                        };
                        ?>
                        <div
                            class="card-content"
                            onclick="location.href='<?php echo $targetPage; ?>?course=<?php echo urlencode($course); ?>&section=<?php echo urlencode($section['section_name']); ?>';"
                            style="cursor: pointer;">
                            <h3><?php echo htmlspecialchars($section['section_name']); ?></h3>
                        </div>
                        <button
                            class="delete-btn"
                            onclick="location.href='?course=<?php echo urlencode($course); ?>&delete=<?php echo $section['id']; ?>';">
                            &times;
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
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
