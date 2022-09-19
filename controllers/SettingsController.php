<?php

class SettingsController
{
    public function actionIndex(): bool
    {
        require_once(ROOT . '/views/settings/index.php');

        return true;
    }
}
