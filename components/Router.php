<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    // Получение строки запроса
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {

            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    #Method
    private function getMethod()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {

            return trim(ucfirst(strtolower($_SERVER['REQUEST_METHOD'])), '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        $method = $this->getMethod();

        // Проверка наличия данного запроса в routes.php
        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~^$uriPattern$~", $uri)) {

                // Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~^$uriPattern$~", $path, $uri);

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . $method . ucfirst(array_shift($segments));

                $parameters = $segments;

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                } else {

                    require_once(ROOT . '/views/errors/404.php');
                }

                $controllerObject = new $controllerName;

                if (method_exists($controllerObject, $actionName)) {
                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                } else {

                    $result =  include_once(ROOT . '/views/errors/404.php');
                }

                if ($result != null) {

                    break;
                }
            }
        }
    }
}
