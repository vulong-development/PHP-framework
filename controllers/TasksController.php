<?php

class TasksController
{
    public function actionIndex(): bool
    {
        require_once(ROOT . '/views/tasks/index.php');

        return true;
    }
}
