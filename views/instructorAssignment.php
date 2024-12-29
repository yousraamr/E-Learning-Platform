<?php
session_start();
require_once(__DIR__ . '/../models/instructorModel.php'); 


// Create an instance of Instructor
$instructor = new Instructor();

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the assignment title, due date, and file
    $title = $_POST['assignmentTitle'];
    $dueDate = $_POST['dueDate'];
    $file = $_FILES['assignmentFile'];

    // Call the addAssignment method from Instructor model
    $message = $instructor->addAssignment($title, $dueDate, $file);

    // Store the message in session to show on the page
    $_SESSION['message'] = $message;

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Display the success message if available
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';

// Clear the message after displaying it
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Instructor: Add Assignment</title>
    <link rel="stylesheet" href="../assets/css/Quiz1.css" />
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1em;
        }

        label {
            display: inline-block;
            width: 100%;
            text-align: left;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        button {
            width: 80%;
            max-width: 400px;
            margin: 0 auto;
        }

        button {
            margin-top: 1em;
        }

        .message {
            color: green;
            font-weight: bold;
            margin-top: 1em;
        }
    </style>
</head>
<body>
    <header>
        <h1>Instructor: Add Assignment</h1>
    </header>
    <main>
        <section class="assignment-upload">
            <h2>Upload Assignment</h2>
            
            <!-- Display any message here -->
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <form id="assignmentForm" action="" method="POST" enctype="multipart/form-data">
                <label for="assignmentTitle">Assignment Title:</label>
                <input
                    type="text"
                    id="assignmentTitle"
                    name="assignmentTitle"
                    placeholder="Enter Assignment Title"
                    required
                />

                <label for="assignmentFile">Upload File:</label>
                <input type="file" id="assignmentFile" name="assignmentFile" required />

                <label for="dueDate">Due Date:</label>
                <input
                    type="date"
                    id="dueDate"
                    name="dueDate"
                    required
                />

                <button type="submit" id="saveAssignment">Add Assignment</button>
            </form>
        </section>
    </main>
</body>
</html>
