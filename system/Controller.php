<?php
namespace app\system;

/**
 * Контроллер
 * @var string $id ID контроллера
 * @var string $layout
 * @var View $view
 *
 * @package app\system
 */
class Controller {
    const CONTROLLER_NAMESPACE = 'app\\controllers\\';

    public $layout = 'main';

    private $id;
    private $view;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->view = new View();
    }

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return View
     */
    public function getView() {
        return $this->view;
    }

    /**
     * @param string $template
     * @param array $params параметры для вывода в шаблон
     *
     * @return string
     */
    public function render($template, $params = [])
    {
        $content = $this->renderPartial($template, $params);

        return $this->getView()->render($this->layout, 'layouts', ['content' => $content]);
    }

    /**
     * @param string $template
     * @param array $params
     *
     * @return string
     */
    public function renderPartial($template, $params)
    {
        return $this->getView()->render($template, $this->getId(), $params);
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}
