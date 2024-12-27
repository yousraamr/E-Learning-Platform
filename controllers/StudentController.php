<?php
include_once __DIR__ . '/../models/studentModel.php';
require_once(__DIR__ . '/../db/config.php');

class StudentController
{
    private $connection;
    private $student;

    public function __construct($connection)
    {
        $this->connection = $connection;

     

        $this->student = new Student($connection, $_SESSION['user_id']);
    }

   
    public function getSections($course)
    {
        return $this->student->getSections($course);
    }

    public function getSectionFiles($course, $section)
    {
        return $this->student->getSectionFiles($course, $section);
        
       
    }


   
}
?>
