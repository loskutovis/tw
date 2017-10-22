<?php
namespace app\models;

use app\system\Model;

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
     * @param $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param $url
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
