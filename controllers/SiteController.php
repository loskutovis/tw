<?php
namespace app\controllers;

use app\system\Controller;
use app\models\Result;

class SiteController extends Controller
{
    /**
     * Вывод главной страницы
     */
    public function actionIndex()
    {
        echo $this->render('index');
    }

    /**
     * Поиск элементов на указанной странице и сохранение их в БД
     */
    public function actionGetPage()
    {
        if ($this->isAjax()) {
            echo json_encode(Result::searchPage($_POST));
        } else {
            $this->actionError();
        }
    }

    /**
     * Вывод страницы результатов
     */
    public function actionResult()
    {
        $result = Result::findAll();

        echo $this->render('result', ['result' => $result]);
    }

    /**
     * Обработка несуществующих адресов
     */
    public function actionError()
    {
        http_response_code(404);

        echo $this->render('error');
    }
}
