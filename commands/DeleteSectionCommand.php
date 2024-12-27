<?php
class DeleteSectionCommand implements Command {
    private $controller;
    private $instructorId;
    private $sectionId;
    private $course;

    public function __construct($controller, $instructorId, $sectionId, $course) {
        $this->controller = $controller;
        $this->instructorId = $instructorId;
        $this->sectionId = $sectionId;
        $this->course = $course;
    }

    public function execute() {
        return $this->controller->deleteSection($this->instructorId, $this->sectionId, $this->course);
    }
}
?>
