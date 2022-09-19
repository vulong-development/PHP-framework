<?php

class AnalyticsController
{
    public function actionIndex(): bool
    {
        require_once(ROOT . '/views/analytics/index.php');

        return true;
    }
}
