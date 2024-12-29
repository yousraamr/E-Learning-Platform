<?php
// Create connection
$conn = new mysqli('localhost', 'root', '', 'e-learning platform');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Path to the JSON file where assignment metadata is stored
$jsonFile = 'assignments.json';

// Check if the file exists
if (file_exists($jsonFile)) {
    // Read the content of the assignments JSON file
    $assignments = json_decode(file_get_contents($jsonFile), true);
} else {
    // If the file doesn't exist, initialize an empty array
    $assignments = [];
}

// Check if the form is submitted for assignment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['answerFile'])) {
    $answerFile = $_FILES['answerFile'];
    $assignmentTitle = $_POST['assignmentTitle']; // The title of the assignment being submitted
    $studentName = 'Malak'; // Replace this with the actual student name (e.g., from session or user data)
    
    // Set the upload directory for the answers
    $uploadDirectory = "uploads/answers/";
    $fileName = basename($answerFile['name']);
    $filePath = $uploadDirectory . $fileName;

    // Check if the file is uploaded successfully
    if ($answerFile['error'] == 0) {
        // Ensure the upload directory exists
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Move the file to the designated directory
        if (move_uploaded_file($answerFile['tmp_name'], $filePath)) {
            // Success: Log the submission details in the database
            $sql = "INSERT INTO assignment_submissions (student_name, assignment_name, submitted) 
                    VALUES (?, ?, 1)"; // Set 'submitted' to 1 to indicate the student submitted the assignment

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $studentName, $assignmentTitle);

            if ($stmt->execute()) {
                // Success message
                $submissionMessage = "Your answer for '$assignmentTitle' has been submitted successfully!";
            } else {
                // Error message if database insertion fails
                $submissionMessage = "Failed to log submission in the database.";
            }

            // Close the statement
            $stmt->close();
        } else {
            $submissionMessage = "Failed to upload your answer file. Please try again.";
        }
    } else {
        $submissionMessage = "There was an error with the file upload. Please ensure the file is valid.";
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student: Assignment Submission</title>
    <link rel="stylesheet" href="../assets/css/Quiz1.css" />
</head>
<body>
    <header>
        <h1>Student: Assignment Submission</h1>
    </header>
    <main>
        <section class="assignment-list">
            <h2>Assignments</h2>
            <div id="assignmentsContainer">
                <?php if (empty($assignments)): ?>
                    <p>No assignments available.</p>
                <?php else: ?>
                    <!-- Display the first assignment (assuming only one for now) -->
                    <div class="assignment-item">
                        <h3>Assignment: <?= htmlspecialchars($assignments[0]['title']) ?></h3>
                        <p>File: <a href="uploads/assignments/<?= htmlspecialchars($assignments[0]['fileName']) ?>" download>Download</a></p>

                        <!-- Form to submit answers -->
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="assignmentTitle" value="<?= htmlspecialchars($assignments[0]['title']) ?>">
                            <label for="answerFile">Upload Your Answer:</label>
                            <input type="file" name="answerFile" id="answerFile" required />
                            <button type="submit">Submit Your Answer</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php if (isset($submissionMessage)): ?>
            <p style="color: green; font-weight: bold;"><?php echo $submissionMessage; ?></p>
        <?php endif; ?>
    </main>
</body>
</html>