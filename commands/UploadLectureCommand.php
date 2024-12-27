<?php
class UploadLectureCommand implements Command {
    private $controller;
    private $courseId;
    private $sectionId;
    private $file;
    private $directory;

    public function __construct($controller, $courseId, $sectionId, $file, $directory) {
        $this->controller = $controller;
        $this->courseId = $courseId;
        $this->sectionId = $sectionId;
        $this->file = $file;
        $this->directory = $directory;
    }

    public function execute() {
        return $this->controller->uploadLecture($this->courseId, $this->sectionId, $this->file, $this->directory);
    }
}
?>
