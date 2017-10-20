<?php
namespace app\system;

class Controller {
    const NAMESPACE = 'app\\controllers\\';

    public $id;
    public $layout;

    private $view;

    public function __construct($id)
    {
        $this->id = $id;
        $this->layout = 'main';
    }

    public function getView() {
        if ($this->view === null) {
            $this->view = new View($this->id);
        }

        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
    }

    public function render($template, $params = [])
    {
        $content = $this->renderPartial($template, $params);

        return $this->getView()->render($this->layout, 'layouts', ['content' => $content]);
    }

    public function renderPartial($template, $params)
    {
        return $this->getView()->render($template, $this->id, $params);
    }
}
