<?php

// FRONT CONTROLLER

session_start();

define('ROOT', dirname(__FILE__));
require_once('../components/Autoload.php');

//Вызов Router
$router = new Router();
$router->run();
