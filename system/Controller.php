<?php
namespace app\controllers;

use app\views\View;

class Controller {
    public $model;
    public $view;

    function __construct()
    {
        $this->view = new View();
    }
}
