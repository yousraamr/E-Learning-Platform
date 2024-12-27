<?php
include_once __DIR__ . '/Command.php';
include_once __DIR__ . '/../controllers/instructorController.php';

class FetchSectionsCommand implements Command {
    private $controller;
    private $instructorId;
    private $course;

    public function __construct($controller, $instructorId, $course) {
        $this->controller = $controller;
        $this->instructorId = $instructorId;
        $this->course = $course;
    }

    public function execute() {
        return $this->controller->getSections($this->instructorId, $this->course);
    }
}
?>
