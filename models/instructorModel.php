<?php
require_once(__DIR__ . '/User.php'); 
require_once(__DIR__ . '/../db/config.php');

class Instructor extends  User {
    public $connection;

    public function __construct($connection = null, $username = null, $email = null, $password = null, $usertype = 'admin', $courses = [])
    {
        if ($connection === null) {
            $this->connection = mysqli_connect($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['database']);

            if (!$this->connection) {
                die('Database connection failed: ' . mysqli_connect_error());
            }
        } else {
            $this->connection = $connection;
        }

        if ($username !== null && $email !== null && $password !== null) {
            parent::__construct($connection, $username, $email, $password, $usertype, $courses);
        }
    }

    public function getCourseSections($userId, $courseName) {
        $query = "
            SELECT cs.id, cs.section_name 
            FROM course_sections cs 
            INNER JOIN user_courses uc ON uc.course_name = cs.course_name 
            WHERE uc.user_id = ? AND cs.course_name = ?
        ";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("is", $userId, $courseName);
        $stmt->execute();
        $result = $stmt->get_result();

        $sections = [];
        while ($row = $result->fetch_assoc()) {
            $sections[] = $row;
        }
        return $sections;
    }

    public function addCourseSection($userId, $courseName, $sectionName) {
        $query = "INSERT INTO course_sections (course_name, section_name) VALUES (?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $courseName, $sectionName);
        if ($stmt->execute()) {
            return "Section added successfully!";
        }
        return "Error adding section: " . $stmt->error;
    }

    public function deleteCourseSection($userId, $sectionId, $courseName) {
        $query = "DELETE FROM course_sections WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $sectionId);
        if ($stmt->execute()) {
            return "Section deleted successfully!";
        }
        return "Error deleting section: " . $stmt->error;
    }

  public function uploadLecture($course, $section, $file, $uploadDirectory) {
    
    $allowedTypes = ['pdf', 'ppt', 'pptx', 'docx'];

    
    $fileName = basename($file['name']);
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

   
    if (!in_array($fileType, $allowedTypes)) {
        return "Error: Invalid file type.";
    }

    if (!is_dir($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0777, true)) {
            return "Error: Failed to create the directory.";
        }
    }

    $uniqueFileName = uniqid() . "_" . $fileName;
    $targetFilePath = "$uploadDirectory/$uniqueFileName";

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        $query = "INSERT INTO uploads (file_name, course_id, section_id) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("sii", $uniqueFileName, $course, $section);

        if ($stmt->execute()) {
            return "File uploaded successfully!";
        } else {
            unlink($targetFilePath); 
            return "Database error: " . $stmt->error;
        }
    } else {
        return "Error: Unable to upload the file.";
    }
}

    public function deleteLecture($courseId, $sectionId, $fileName) {
        $baseDirectory = __DIR__ . "/../views/uploads";
        $directory = "$baseDirectory/$courseId/$sectionId";
        $filePath = $directory . '/' . $fileName;
      

            $query = "DELETE FROM uploads WHERE file_name = ? AND course_id = ? AND section_id = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("sii", $fileName, $courseId, $sectionId);
            if ($stmt->execute()) {
                return "File deleted successfully!";
            } else {
                return "Database error: " . $stmt->error;
            }
    }

    public function listLectures($courseId, $sectionId) {
        $query = "SELECT file_name FROM uploads WHERE course_id = ? AND section_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $courseId, $sectionId);
        $stmt->execute();
        $result = $stmt->get_result();

        $files = [];
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }

        return $files;
    }

    // Add a quiz question
    public function addQuizQuestion($questionText, $options, $correctOption) {
        $stmt = $this->connection->prepare("INSERT INTO quiz_questions (question_text, option_1, option_2, option_3, option_4, correct_option) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $questionText, $options[0], $options[1], $options[2], $options[3], $correctOption);

        if ($stmt->execute()) {
            return "Question added successfully!";
        } else {
            return "Error adding question: " . $stmt->error;
        }
    }

    // Edit a quiz question
    public function editQuizQuestion($questionId, $questionText, $options, $correctOption) {
        $stmt = $this->connection->prepare("UPDATE quiz_questions SET question_text = ?, option_1 = ?, option_2 = ?, option_3 = ?, option_4 = ?, correct_option = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $questionText, $options[0], $options[1], $options[2], $options[3], $correctOption, $questionId);

        if ($stmt->execute()) {
            return "Question updated successfully!";
        } else {
            return "Error updating question: " . $stmt->error;
        }
    }

    // Delete a quiz question
    public function deleteQuizQuestion($questionId) {
        $stmt = $this->connection->prepare("DELETE FROM quiz_questions WHERE id = ?");
        $stmt->bind_param("i", $questionId);

        if ($stmt->execute()) {
            return "Question removed successfully!";
        } else {
            return "Error removing question: " . $stmt->error;
        }
    }

    // Retrieve all quiz questions
    public function getQuizQuestions() {
        $result = $this->connection->query("SELECT * FROM quiz_questions");
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
        return $questions;
    }

    public function addAssignment($title, $dueDate, $file) {
        
        $instructorName = isset($_SESSION['instructor_name']) ? $_SESSION['instructor_name'] : 'Default Instructor';

        
        $uploadDirectory = "uploads/";

       
        $fileName = basename($file['name']);
        $filePath = $uploadDirectory . $fileName;

        
        if ($file['error'] == 0 && !empty($title) && !empty($dueDate)) {
            
            $stmt_check = $this->connection->prepare("SELECT id FROM assignments WHERE assignment_name = ? AND due_date = ?");
            $stmt_check->bind_param("ss", $title, $dueDate);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                return "Assignment with this title and due date already exists.";
            } else {
               
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    
                    $stmt = $this->connection->prepare("INSERT INTO assignments (assignment_name, instructor_name, file_name, due_date) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $title, $instructorName, $fileName, $dueDate); // Use the logged-in instructor name
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        return "Assignment uploaded and saved successfully!";
                    } else {
                        return "Failed to save assignment to the database.";
                    }
                } else {
                    return "Failed to upload the file.";
                }
            }
            $stmt_check->close();
        } else {
            return "Please fill out all fields and upload a valid file.";
        }
    }    
}
?>
