<?php
namespace app\system;

/**
 * Class Autoloader
 *
 * @package app\system
 */
class Autoloader
{
    protected $namespacesMap = [];

    /**
     * @param $namespace
     * @param $rootDir
     *
     * @return bool
     */
    public function addNamespace($namespace, $rootDir)
    {
        if (is_dir($rootDir)) {
            $this->namespacesMap[$namespace] = $rootDir;

            return true;
        }

        return false;
    }

    /**
     *
     */
    public function register()
    {
        spl_autoload_register([$this, 'autoload']);
    }

    /**
     * @param $class
     *
     * @return bool
     */
    protected function autoload($class)
    {
        $class = str_replace('app\\', '', $class);
        $pathParts = explode('\\', $class);

        if (is_array($pathParts)) {
            $namespace = 'app\\'.array_shift($pathParts);

            if (!empty($this->namespacesMap[$namespace])) {
                $filePath = __DIR__.'/../'.$this->namespacesMap[$namespace] . '/' . implode('/', $pathParts) . '.php';

                if (file_exists($filePath)) {
                    require_once $filePath;

                    return true;
                }
            }
        }

        return false;
    }
}
