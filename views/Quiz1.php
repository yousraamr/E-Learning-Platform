<?php
session_start();
require_once('../models/instructorModel.php');

// Instantiate the Instructor object
$instructor = new Instructor();

// Fetch all quiz questions from the database
$quiz_questions = $instructor->getQuizQuestions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <link rel="stylesheet" href="../assets/css/Quiz1.css">
</head>
<body>
    <header>
        <h1>Take Quiz</h1>
    </header>
    <main>
        <form method="POST" action="submitQuiz.php">
            <?php if (!empty($quiz_questions)): ?>
                <?php foreach ($quiz_questions as $index => $question): ?>
                    <div class="question">
                        <p><?= ($index + 1) . ". " . htmlspecialchars($question['question_text']) ?></p>
                        <?php foreach (['option_1', 'option_2', 'option_3', 'option_4'] as $optionIndex => $optionKey): ?>
                            <label>
                                <input type="radio" name="q<?= $index ?>" value="<?= $optionIndex + 1 ?>" required>
                                <?= htmlspecialchars($question[$optionKey]) ?>
                            </label>
                            <br>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <button type="submit">Submit Quiz</button>
            <?php else: ?>
                <p>No questions available. Please check back later!</p>
            <?php endif; ?>
        </form>
    </main>
</body>
</html>
