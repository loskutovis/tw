<?php
namespace app;

class Router
{
    const CONTROLLERS_NAMESPACE = 'app\\controllers\\';

    public static function start()
    {
        $controllerName = 'site';
        $actionName = 'index';

        $url = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($url[1])) {
            $controllerName = $url[1];
        }

        if (!empty($url[2])) {
            $actionName = $url[2];
        }

        $controllerName = static::CONTROLLERS_NAMESPACE.ucfirst($controllerName).'Controller';
        $actionName = 'action'.$actionName;

        $controller = new $controllerName;

        if (method_exists($controller, $actionName)) {
            $controller->$actionName;
        } else {
            var_dump($controllerName, $actionName);
        }
    }
}
