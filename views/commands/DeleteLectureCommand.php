<?php
class DeleteLectureCommand implements Command {
    private $controller;
    private $courseId;
    private $sectionId;
    private $fileName;

    public function __construct($controller, $courseId, $sectionId, $fileName) {
        $this->controller = $controller;
        $this->courseId = $courseId;
        $this->sectionId = $sectionId;
        $this->fileName = $fileName;
    }

    public function execute() {
        return $this->controller->deleteLecture($this->courseId, $this->sectionId, $this->fileName);
    }
}
?>
