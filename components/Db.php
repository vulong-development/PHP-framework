<?php

class Db
{

    public static function getConnection(): PDO
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        $db = null;

        try {
            $db = new PDO("mysql:host={$params['host']}; dbname={$params['dbname']}; charset=utf8", $params['user'], $params['password'], [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOExeception $Exeption) {

            echo 'Подключение не удалось: ' . $Exeption->getMessage();

        }

        return $db;
    }
}






