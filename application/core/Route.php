<?php

/**
 * Класс-маршрутизатор для определения запрашиваемой страницы.
 * цепляет классы контроллеров и моделей;
 * создает экземпляры контролеров страниц и вызывает действия этих контроллеров.
 */
class Route
{
    public static function start()
    {
        $controllerName = 'Main';
        $actionName = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        $modelName = 'Model' . ucfirst($controllerName);
        $controllerName = 'Controller' . ucfirst($controllerName);
        $actionName = 'action' . ucfirst($actionName);

        $modelFile = ucfirst($modelName) . '.php';

        if (file_exists("application/models/" . $modelFile)) {
            include "application/models/" . $modelFile;
        }

        $controllerFile = $controllerName . '.php';

        if (file_exists("application/controllers/" . $controllerFile)) {
            include "application/controllers/" . $controllerFile;
        } else {
            Route::ErrorPage404();
        }

        $controller = new $controllerName;
        $action = $actionName;

        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Route::ErrorPage404();
        }
    }

    public static function ErrorPage404()
    {
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location: http://' . APPLICATION_HOST . '/' . '404');
    }
}
