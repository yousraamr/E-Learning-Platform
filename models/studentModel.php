<?php
// studentModel.php
require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/../db/config.php'); 

class Student extends User
{
    public $connection;
    public $studentId;

   
    public function __construct($connection, $studentId = null, $username = null, $email = null, $password = null, $usertype = 'student', $courses = [])
    {
        if ($connection === null) {
            $this->connection = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);

            if (!$this->connection) {
                die('Database connection failed: ' . mysqli_connect_error());
            }
        } else {
            $this->connection = $connection;
        }
        parent::__construct($connection, $username, $email, $password, $usertype, $courses); 
        $this->studentId = $studentId;
    }
   
    public function getSections($courseName)
    {
        $query = $this->connection->prepare("SELECT section_name FROM course_sections WHERE course_name = ?");
        $query->bind_param("s", $courseName);
        $query->execute();
        $result = $query->get_result();
        $sections = [];
        while ($row = $result->fetch_assoc()) {
            $sections[] = $row;
        }
        return $sections;
    }
    public function getSectionFiles($course, $section)
    {
        $files = [];
        $query = "SELECT u.file_name 
                FROM uploads u
                INNER JOIN user_courses uc ON u.course_id = uc.id
                INNER JOIN course_sections cs ON u.section_id = cs.id
                WHERE uc.course_name = ? AND cs.section_name = ?";

        $stmt = $this->connection->prepare($query);

      
        $stmt->bind_param("ss", $course, $section);
        $stmt->execute();
        $result = $stmt->get_result();

       
        while ($row = $result->fetch_assoc()) {
            $files[] = $row['file_name'];
        }

        return $files;
    }

    // Method to get quiz questions from the database
    public function getQuizQuestions()
    {
        $query = "SELECT * FROM quiz_questions";
        $result = $this->connection->query($query);
        $quiz_questions = [];

        while ($row = $result->fetch_assoc()) {
            $quiz_questions[] = [
                'id' => $row['id'],
                'question_text' => $row['question_text'],
                'options' => [
                    $row['option_1'],
                    $row['option_2'],
                    $row['option_3'],
                    $row['option_4']
                ],
                'correct_option' => $row['correct_option']
            ];
        }

        return $quiz_questions;
    }

    // Method to submit the quiz, calculate score and save the results
    public function submitQuiz($answers)
    {
        // Fetch the quiz questions from the database
        $quiz_questions = $this->getQuizQuestions();
    
        // Initialize variables for score calculation
        $correctAnswers = 0;
        $totalQuestions = count($quiz_questions);
    
        // Loop through the quiz questions and check the answers
        foreach ($quiz_questions as $index => $question) {
            // Check if the student's answer matches the correct option
            if (isset($answers["q$index"]) && $answers["q$index"] == $question['correct_option']) {
                $correctAnswers++;
            }
        }
    
        // Calculate the score
        $score = ($correctAnswers / $totalQuestions) * 100;
    
        // Save the score to the database
        $stmt = $this->connection->prepare("INSERT INTO quiz_results (student_id, score, submission_time) VALUES (?, ?, CURRENT_TIMESTAMP)");
        $stmt->bind_param("id", $this->studentId, $score);
        
        // Log the query and parameters for debugging
        echo "Query: " . $stmt->get_stmt() . "\n";
        echo "Student ID: " . $this->studentId . ", Score: " . $score . "\n";
        
        $stmt->execute();
    
        // Return the result in "correct/total" format
        return "$correctAnswers/$totalQuestions";  
    }
    
    // Fetch assignments from the database
    public function getAssignments()
    {
        $sql = "SELECT assignment_name FROM assignments";
        $result = $this->connection->query($sql);
        $assignments = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $assignments[] = $row['assignment_name'];
            }
        }

        return $assignments;
    }

    // Handle the assignment submission
    public function submitAssignment($assignmentName, $file)
    {
        $uploadDir = 'uploads/answers/';
        $uploadFile = $uploadDir . basename($file['name']);
        $studentName = 'Student Name'; // Get from session or user data
        $submissionTime = date('Y-m-d H:i:s');

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Check if assignment has already been submitted
        if (isset($_SESSION['submitted_assignments']) && in_array($assignmentName, $_SESSION['submitted_assignments'])) {
            return "Submission for this assignment already exists.";
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // Insert submission into the database
            $stmt = $this->connection->prepare("INSERT INTO assignment_submissions (student_name, assignment_name, submitted_file, submission_time) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $studentName, $assignmentName, $uploadFile, $submissionTime);
            $stmt->execute();
            $stmt->close();

            // Store submission in session
            if (!isset($_SESSION['submitted_assignments'])) {
                $_SESSION['submitted_assignments'] = [];
            }
            $_SESSION['submitted_assignments'][] = $assignmentName;

            return "Answer submitted successfully: <a href='$uploadFile' download>" . $file['name'] . "</a>";
        } else {
            return "Error uploading file.";
        }
    }
}
?>