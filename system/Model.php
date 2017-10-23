<?php
namespace app\system;

use PDO;
use PDOException;

/**
 * Модель
 * @var string $tableName имя таблицы в БД
 * @var mixed $db соединение с БД
 *
 * @package app\system
 */
abstract class Model
{
    private static $tableName;
    private static $db;

    /**
     * @return mixed
     */
    public abstract function toArray();

    /**
     * @return mixed
     */
    public static function getTableName()
    {
        return static::$tableName;
    }

    /**
     * @return mixed
     */
    public function save()
    {
        $params = $this->toArray();

        $table = static::getTableName();
        $fields = implode(', ', array_keys($params));

        $data = self::prepareParams($params);
        $params = implode(', ', array_keys($data));

        $db = self::getConnection();

        $stmt = $db->prepare("INSERT INTO $table ($fields) VALUES ($params)");

        return $stmt->execute($data);
    }

    /**
     * @return mixed
     */
    public static function getConnection()
    {
        if (empty(self::$db)) {
            if (file_exists(__DIR__ . '/../config/config.php')) {
                require_once __DIR__ . '/../config/config.php';

                /**
                 * @var mixed $db конфигурация БД
                 */
                $dsn = "mysql:host={$db['host']};dbname={$db['dbName']};charset={$db['charset']}";

                $opt = [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ];

                try {
                    self::$db = new PDO($dsn, $db['user'], $db['pass'], $opt);
                } catch (PDOException $e) {
                    die('Подключение не удалось: ' . $e->getMessage());
                }
            } else {
                die('Не найден файл конфигурации');
            }
        }

        return self::$db;
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public static function prepareParams($params)
    {
        $data = [];

        foreach ($params as $key => $param) {
            $data[':' . $key] = $param;
        }

        return $data;
    }
}
