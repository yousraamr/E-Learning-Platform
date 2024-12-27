<?php
class CommandInvoker {
    public function execute(Command $command) {
        return $command->execute();
    }
}
?>
