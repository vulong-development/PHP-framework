<?php

namespace ErrorController;

class ErrorController
{
    public function actionGetIndex(): bool
    {
        require_once(ROOT . '/views/board/index.php');

        return true;
    }
}
