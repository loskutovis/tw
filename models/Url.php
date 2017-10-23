<?php
namespace app\models;

use app\system\Model;

/**
 * Класс для работы с адресами сайтов
 *
 * @package app\models
 */
class Url extends Model
{
    private static $tableName = 'url';

    private $id;
    private $url;

    /**
     * @return mixed
     */
    public static function getTableName() {
        return static::$tableName;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param string $url
     *
     * @return mixed
     */
    public function getByUrl($url) {
        $table = static::getTableName();
        $data = ['url' => $url];

        $stmt = self::getConnection()->prepare("SELECT * FROM $table WHERE url LIKE :url");

        $stmt->execute($data);

        return $stmt->fetchAll();
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'url' => $this->url,
        ];
    }
}
