<?php
namespace app\system;

use app\controllers\SiteController;
use Error;

/**
 * Class Router
 * @package app\system
 */
class Router
{
    /**
     * Старт обработки url
     */
    public static function start()
    {
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
                static::showError();
            }
        } catch (Error $error) {
            static::showError();
        }
    }

    /**
     * Обработка ошибки 404
     */
    private static function showError() {
        call_user_func_array([new SiteController('site'), 'actionError'], []);
    }
}
