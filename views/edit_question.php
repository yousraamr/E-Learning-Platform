<?php
session_start();
require_once(__DIR__ . '/../models/instructorModel.php');

// Instantiate the Instructor object
$instructor = new Instructor();

// Check if 'id' parameter is passed
if (isset($_GET['id'])) {
    $questionId = intval($_GET['id']);

    // Retrieve the question data
    $stmt = $instructor->connection->prepare("SELECT * FROM quiz_questions WHERE id = ?");
    $stmt->bind_param("i", $questionId);
    $stmt->execute();
    $result = $stmt->get_result();
    $question = $result->fetch_assoc();

    if (!$question) {
        $_SESSION['message'] = "Question not found!";
        header('Location: instructorQuiz.php');
        exit;
    }

    // Handle form submission to update the question
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $questionText = $_POST['question_text'];
        $options = [
            $_POST['option_1'],
            $_POST['option_2'],
            $_POST['option_3'],
            $_POST['option_4']
        ];
        $correctOption = intval($_POST['correct_option']);

        $message = $instructor->editQuizQuestion($questionId, $questionText, $options, $correctOption);
        $_SESSION['message'] = $message;
        header('Location: instructorQuiz.php');
        exit;
    }
} else {
    $_SESSION['message'] = "No question ID specified!";
    header('Location: instructorQuiz.php');
    exit;
}

// Retrieve message from session
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Quiz Question</title>
    <link rel="stylesheet" href="../assets/css/Quiz1.css" />
</head>
<body>
    <header>
        <h1>Edit Quiz Question</h1>
    </header>
    <main>
        <?php if ($message): ?>
            <p style="color: green; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div>
                <label for="question-text">Question:</label><br />
                <textarea id="question-text" name="question_text" rows="3" required><?= htmlspecialchars($question['question_text']) ?></textarea>
            </div>
            <div>
                <label for="option-1">Option 1:</label>
                <input type="text" id="option-1" name="option_1" value="<?= htmlspecialchars($question['option_1']) ?>" required /><br />
                <label for="option-2">Option 2:</label>
                <input type="text" id="option-2" name="option_2" value="<?= htmlspecialchars($question['option_2']) ?>" required /><br />
                <label for="option-3">Option 3:</label>
                <input type="text" id="option-3" name="option_3" value="<?= htmlspecialchars($question['option_3']) ?>" required /><br />
                <label for="option-4">Option 4:</label>
                <input type="text" id="option-4" name="option_4" value="<?= htmlspecialchars($question['option_4']) ?>" required /><br />
            </div>
            <div>
                <label for="correct-option">Correct Option (1, 2, 3, or 4):</label>
                <input type="number" id="correct-option" name="correct_option" value="<?= htmlspecialchars($question['correct_option']) ?>" min="1" max="4" required />
            </div>
            <button type="submit">Save Changes</button>
        </form>
    </main>
</body>
</html>
