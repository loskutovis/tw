<?php
namespace app\system;

/**
 * Class Controller
 *
 * @package app\system
 */
class Controller {
    const CONTROLLER_NAMESPACE = 'app\\controllers\\';

    public $id;
    public $layout;

    private $view;

    /**
     * Controller constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->layout = 'main';
    }

    /**
     * @return View
     */
    public function getView() {
        if ($this->view === null) {
            $this->view = new View($this->id);
        }

        return $this->view;
    }

    /**
     * @param $view
     */
    public function setView($view) {
        $this->view = $view;
    }

    /**
     * @param $template
     * @param array $params
     *
     * @return string
     */
    public function render($template, $params = [])
    {
        $content = $this->renderPartial($template, $params);

        return $this->getView()->render($this->layout, 'layouts', ['content' => $content]);
    }

    /**
     * @param $template
     * @param $params
     *
     * @return string
     */
    public function renderPartial($template, $params)
    {
        return $this->getView()->render($template, $this->id, $params);
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}
