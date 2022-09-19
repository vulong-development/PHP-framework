<?php

class ProfileController
{
    public function actionIndex(): bool
    {
        require_once(ROOT . '/views/profile/index.php');

        return true;
    }
}
