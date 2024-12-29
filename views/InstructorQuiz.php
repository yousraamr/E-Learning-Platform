<?php
session_start();
require_once(__DIR__ . '/../models/instructorModel.php');

// Instantiate the Instructor object
$instructor = new Instructor();

// Handle form submission to add a new question
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $questionText = $_POST['question_text'];
    $options = [
        $_POST['option_1'],
        $_POST['option_2'],
        $_POST['option_3'],
        $_POST['option_4']
    ];
    $correctOption = intval($_POST['correct_option']);

    $message = $instructor->addQuizQuestion($questionText, $options, $correctOption);
    $_SESSION['message'] = $message;

    // Redirect to prevent form resubmission
    header('Location: instructorQuiz.php');
    exit;
}

// Handle deletion of a question
if (isset($_GET['delete_id'])) {
    $questionId = intval($_GET['delete_id']);
    $message = $instructor->deleteQuizQuestion($questionId);
    $_SESSION['message'] = $message;

    // Redirect to prevent direct access to the deletion URL
    header('Location: instructorQuiz.php');
    exit;
}

// Retrieve all quiz questions from the database
$quizQuestions = $instructor->getQuizQuestions();

// Retrieve message from session
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instructor - Manage Quiz Questions</title>
    <link rel="stylesheet" href="../assets/css/Quiz1.css" />
</head>
<body>
    <header>
        <h1>Instructor - Manage Quiz Questions</h1>
    </header>
    <main>
        <?php if ($message): ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="action" value="add" />
            <div>
                <label for="question-text">Question:</label><br />
                <textarea id="question-text" name="question_text" rows="3" required></textarea>
            </div>
            <div>
                <label for="option-1">Option 1:</label>
                <input type="text" id="option-1" name="option_1" required /><br />
                <label for="option-2">Option 2:</label>
                <input type="text" id="option-2" name="option_2" required /><br />
                <label for="option-3">Option 3:</label>
                <input type="text" id="option-3" name="option_3" required /><br />
                <label for="option-4">Option 4:</label>
                <input type="text" id="option-4" name="option_4" required /><br />
            </div>
            <div>
                <label for="correct-option">Correct Option (1, 2, 3, or 4):</label>
                <input type="number" id="correct-option" name="correct_option" min="1" max="4" required />
            </div>
            <button type="submit">Add Question</button>
        </form>

        <h2>Existing Quiz Questions</h2>
        <ul>
            <?php foreach ($quizQuestions as $row): ?>
                <li>
                    <strong><?= htmlspecialchars($row['question_text']) ?></strong><br />
                    Options:
                    1. <?= htmlspecialchars($row['option_1']) ?><br />
                    2. <?= htmlspecialchars($row['option_2']) ?><br />
                    3. <?= htmlspecialchars($row['option_3']) ?><br />
                    4. <?= htmlspecialchars($row['option_4']) ?><br />
                    Correct Option: <?= $row['correct_option'] ?><br />
                    <a href="instructorQuiz.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this question?')">Remove Question</a> |
                    <a href="edit_question.php?id=<?= $row['id'] ?>">Edit Question</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>
