<?php
class AddSectionCommand implements Command {
    private $controller;
    private $instructorId;
    private $course;
    private $sectionName;

    public function __construct($controller, $instructorId, $course, $sectionName) {
        $this->controller = $controller;
        $this->instructorId = $instructorId;
        $this->course = $course;
        $this->sectionName = $sectionName;
    }

    public function execute() {
        return $this->controller->addSection($this->instructorId, $this->course, $this->sectionName);
    }
}
?>
