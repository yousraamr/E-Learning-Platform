<?php
include_once __DIR__ . '/../models/instructorModel.php';

class InstructorController {
    private $model;

    public function __construct($connection) {
        $this->model = new Instructor($connection);
    }

    public function getSections($userId, $courseName) {
        return $this->model->getCourseSections($userId, $courseName);
    }

    public function addSection($userId, $courseName, $sectionName) {
        return $this->model->addCourseSection($userId, $courseName, $sectionName);
    }

    public function deleteSection($userId, $sectionId, $courseName) {
        return $this->model->deleteCourseSection($userId, $sectionId, $courseName);
    }

    public function uploadLecture($courseId, $sectionId, $file, $baseDirectory) {
        return $this->model->uploadLecture($courseId, $sectionId, $file, $baseDirectory);
    }

    public function deleteLecture($courseId, $sectionId, $fileName, $directory) {
        return $this->model->deleteLecture($courseId, $sectionId, $fileName, $directory);
    }
}

$instructorController = new InstructorController($connection);
?>
