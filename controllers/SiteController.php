<?php
namespace app\controllers;

use app\system\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('index');
    }

    public function actionGetPage()
    {
        echo json_encode($_POST);
    }

    public function actionError()
    {
        http_response_code(404);

        echo $this->render('error');
    }
}
