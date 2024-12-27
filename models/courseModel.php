<?php
class CourseModel
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getCoursesByUserId(int $userId): array
    {
        $query = "SELECT course_name FROM user_courses WHERE user_id = ? AND course_name IS NOT NULL AND TRIM(course_name) != ''";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $courses = [];
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row['course_name'];
        }
        return $courses;
    }

    public function courseExists(int $userId, string $courseName): bool
    {
        $query = "SELECT 1 FROM user_courses WHERE user_id = ? AND course_name = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("is", $userId, $courseName);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    public function getCoursePageUrl(string $role, string $courseName): string
    {
        $basePath = "/swe_project/views/";
        $page = match (strtolower($role)) {
            'admin' => 'admin.php',
            'instructor' => 'instructor.php',
            'student' => 'student.php',
            default => 'error.php',
        };
        $courseName = trim($courseName);

    
        
        return $basePath . $page . "?course=" . urlencode($courseName);
    }
}
?>
