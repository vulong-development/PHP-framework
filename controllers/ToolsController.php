<?php

class ToolsController
{

    public function actionIndex(): bool
    {
        require_once(ROOT . '/views/tools/index.php');

        return true;
    }
}
