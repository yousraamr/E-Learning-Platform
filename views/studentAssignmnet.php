<?php
require_once('../models/studentModel.php');

// Start session to store submission status
session_start();

// Initialize Student object
$student = new Student(null, 1); // Replace 1 with the actual student ID if needed

// Fetch assignments
$assignments = $student->getAssignments();

// Handle file upload when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['answerFile'])) {
    $assignmentName = $_POST['assignmentName'];
    $file = $_FILES['answerFile'];

    // Call the submitAssignment method to handle the submission
    $message = $student->submitAssignment($assignmentName, $file);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student: Assignment Review</title>
    <link rel="stylesheet" href="../assets/css/Quiz1.css" />
    <style>
      body { font-family: Arial, sans-serif; }
      header { text-align: center; margin-bottom: 20px; }
      .assignment-list { text-align: center; }
      .answer-upload { display: flex; flex-direction: column; align-items: center; }
      .answer-upload form { width: 300px; }
      label { display: block; margin-bottom: 10px; }
      select, input[type="file"], button { width: 100%; margin-bottom: 15px; }
      .success-message { color: green; font-weight: bold; }
      .error-message { color: red; font-weight: bold; }
    </style>
  </head>
  <body>
    <header>
      <h1>Student: Assignment Review</h1>
    </header>
    <main>
    <section class="assignment-list">
    <h2>Assignments</h2>
    <?php if (empty($assignments)): ?>
        <p>No assignments available.</p>
    <?php else: ?>
        <p>Download your assignment:</p>
        <div class="assignment-item" data-assignment="<?= htmlspecialchars($assignments[0]) ?>">
            <h3>Assignment: <?= htmlspecialchars($assignments[0]) ?></h3>
            <p>File: <a href="uploads/assignments/<?= htmlspecialchars($assignments[0]) ?>" download>Download</a></p>
        </div>
    <?php endif; ?>
</section>

      <!-- Form to upload answer -->
      <section class="answer-upload">
        <form id="answerForm" method="POST" enctype="multipart/form-data">
          <label for="assignmentName">Select Assignment</label>
          <select name="assignmentName" id="assignmentName" required>
            <option value="">-- Select Assignment --</option>
            <?php foreach ($assignments as $assignment): ?>
              <option value="<?= htmlspecialchars($assignment) ?>"><?= htmlspecialchars($assignment) ?></option>
            <?php endforeach; ?>
          </select>

          <label for="answerFile">Upload</label>
          <input type="file" name="answerFile" id="answerFile" required />

          <button type="submit">Add Submission</button>
        </form>

        <?php if (isset($message)): ?>
          <p class="success-message"><?= $message ?></p>
        <?php endif; ?>
      </section>
    </main>
  </body>
</html>