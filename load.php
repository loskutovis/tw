<?php
require_once './system/Autoloader.php';

$autoloader = new \app\system\Autoloader();
$autoloader->addNamespace('app\\system', 'system');
$autoloader->addNamespace('app\\controllers', 'controllers');
$autoloader->addNamespace('app\\models', 'models');
$autoloader->addNamespace('app\\views', 'views');
$autoloader->register();

\app\system\Router::start();
