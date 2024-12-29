<?php
// Start the session
session_start();
require_once('../models/studentModel.php');  // Include the Student class

// Set a default student_id if not using session
$student_id = 1; // Replace with a static or dynamically assigned student_id as needed

// Initialize the Student class
$student = new Student(null, $student_id);

// Get the submitted answers
$answers = $_POST;

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'e-learning platform';
$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch quiz questions from the database
$query = "SELECT * FROM quiz_questions";
$result = $mysqli->query($query);

// Store questions and correct answers
$quiz_questions = [];
while ($row = $result->fetch_assoc()) {
    $quiz_questions[] = [
        'id' => $row['id'],
        'text' => $row['question_text'],
        'options' => [
            $row['option_1'],
            $row['option_2'],
            $row['option_3'],
            $row['option_4']
        ],
        'correct_option' => $row['correct_option'] // Store the correct option number (1-based)
    ];
}

// Initialize variables for score calculation
$totalQuestions = count($quiz_questions);
$correctAnswers = 0;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Loop through the quiz questions to calculate the score
    foreach ($quiz_questions as $index => $question) {
        $studentAnswer = isset($answers["q$index"]) ? $answers["q$index"] : null;

        // Check if the student's answer matches the correct answer
        if ($studentAnswer !== null && $studentAnswer == $question['correct_option']) {
            $correctAnswers++;
        }
    }

    // Calculate the score (correct answers out of total questions)
    $score = "$correctAnswers/$totalQuestions";

    // Save the score to the database
    $student->submitQuizResults($score); // Make sure this method exists in your Student class
} else {
    // If no POST request, set a default message
    $score = "No answers submitted.";
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz Results</title>
    <link rel="stylesheet" href="../assets/css/Quiz1.css" />
</head>
<body>
    <header>
        <h1>Quiz Results</h1>
    </header>
    <main>
        <h2>Your Score: <?= htmlspecialchars($score) ?></h2>
    </main>
</body>
</html>
