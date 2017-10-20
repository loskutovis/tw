<?php
namespace app\system;

class View
{
    private $name;

    public function __construct($viewName)
    {
        $this->name = $viewName;
    }

    public function render($file, $id, $params = [])
    {
        $filePath = "__DIR__/../views/$id/$file.php";

        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);

        if (file_exists($filePath)) {
            require($filePath);
        }

        return ob_get_clean();
    }
}
