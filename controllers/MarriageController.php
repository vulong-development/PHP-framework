<?php

class MarriageController
{
    public function actionIndex(): bool
    {
        require_once(ROOT . '/views/marriage/index.php');

        return true;
    }
}
