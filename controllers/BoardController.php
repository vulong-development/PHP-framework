<?php

class BoardController
{
    public function actionGetIndex(): bool
    {

        require_once(ROOT . '/views/board/index.php');

        return true;
    }
}
