<?php
require_once(__DIR__ . '/../models/CourseModel.php');

class HomeCourseController
{
    private $courseModel;

    public function __construct($connection)
    {
        $this->courseModel = new CourseModel($connection);
    }

    public function getCoursesForUser(int $userId): array
    {
        return $this->courseModel->getCoursesByUserId($userId);
    }

    public function getCoursePageUrl(string $role, string $courseName):string
    {
        return $this->courseModel-> getCoursePageUrl($role,$courseName);
       
      
    }
    
}
?>
