<?php
namespace app\system;

use app\controllers\SiteController;
use Error;

/**
 * Обработка url
 * @package app\system
 */
class Router
{
    /**
     * Старт обработки url
     */
    public static function start()
    {
        $error = false;
        $controllerName = 'site';
        $actionName = 'Index';

        $url = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($url[1])) {
            $controllerName = $url[1];
        }

        if (!empty($url[2])) {
            $actionName = $url[2];
        }

        $controller = Controller::CONTROLLER_NAMESPACE .  ucfirst($controllerName) . 'Controller';
        $actionName = 'action' . ucfirst($actionName);

        try {
            $controller = new $controller($controllerName);

            if (method_exists($controller, $actionName)) {
                call_user_func_array([$controller, $actionName], []);
            } else {
                $error = true;
            }
        } catch (Error $error) {
            $error = true;
        }

        if ($error) {
            $errorController = new SiteController('site');
            $errorAction = 'actionError';

            static::showError($errorController, $errorAction);
        }
    }

    /**
     * Обработка ошибки 404
     * @param Controller $errorController контроллер для обработки ошибки
     * @param string $errorAction обработчик ошибки
     */
    private static function showError($errorController, $errorAction) {
        call_user_func_array([$errorController, $errorAction], []);
    }
}
