<?php
namespace app\controllers;

use app\system\Controller;
use app\models\Result;
use app\system\Model;

class SiteController extends Controller
{
    public function actionIndex()
    {
        echo $this->render('index');
    }

    public function actionGetPage()
    {
        if ($this->isAjax()) {
            echo json_encode(Result::searchPage($_POST));
        } else {
            $this->actionError();
        }
    }

    public function actionResult()
    {
        $result = Result::findAll();

        echo $this->render('result', ['result' => $result]);
    }

    public function actionError()
    {
        http_response_code(404);

        echo $this->render('error');
    }
}
