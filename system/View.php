<?php
namespace app\system;

/**
 * Class View
 *
 * @package app\system
 */
class View
{
    /**
     * Выводит содержимое шаблона
     * @param string $file путь к файлу шаблона
     * @param string $id тип шаблона
     * @param array $params параметры для вывода в шаблон
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
