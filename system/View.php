<?php
namespace app\system;

/**
 * Class View
 *
 * @package app\system
 */
class View
{
    private $name;

    /**
     * View constructor.
     * @param $viewName
     */
    public function __construct($viewName)
    {
        $this->name = $viewName;
    }

    /**
     * @param $file
     * @param $id
     * @param array $params
     *
     * @return string
     */
    public function render($file, $id, $params = [])
    {
        $filePath = "__DIR__/../views/$id/$file.php";

        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);

        if (file_exists($filePath)) {
            require_once($filePath);
        }

        return ob_get_clean();
    }
}
