<?php
namespace app\models;

use app\system\Model;

/**
 * Class Result
 * @var $url
 * @var $found
 * @var $count
 *
 * @package app\models
 */
class Result extends Model
{
    const SEARCH_TEXT = 'text';

    private static $tableName = 'result';

    private $id;
    private $url_id;
    private $found;
    private $count;

    /**
     * @return mixed
     */
    public static function getTableName() {
        return static::$tableName;
    }

    /**
     * @param $url
     *
     * @return $this
     */
    public function setUrlId($url_id)
    {
        $this->url_id = intval($url_id);

        return $this;
    }

    /**
     * @param $found
     *
     * @return $this
     */
    public function setFound($found)
    {
        $this->found = $found;

        return $this;
    }

    /**
     * @param $count
     *
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = intval($count);

        return $this;
    }

    /**
     * @param $params
     *
     * @return bool|static
     */
    public static function searchPage($params)
    {
        $queryResult =  static::validateParams($params);

        if (!$queryResult['error']) {
            $page = static::getPage($params['url']);

            if ($params['search_type'] == static::SEARCH_TEXT && !empty($params['search_text'])) {
                $matches = static::doSearch($page, $params['search_type'], $params['search_text']);
            } elseif ($params['search_type'] !== static::SEARCH_TEXT) {
                $matches = static::doSearch($page, $params['search_type']);
            }
            else {
                $matches = false;
            }

            if ($matches && isset($matches[0])) {
                $result = new static;

                $url = new Url();
                $url->setUrl($params['url']);
                $urlExists = $url->getByUrl($params['url']);

                if ($urlExists) {
                    $result->setUrlId($urlExists[0]['id']);
                } elseif ($url->save()) {
                    $result->setUrlId(self::getConnection()->lastInsertId());
                }

                $result->setCount(count($matches[0]))
                    ->setFound(serialize($matches[0]));

                if (!$result->save()) {
                    $queryResult['error'] = true;
                    $queryResult['description'] = 'Произошла ошибка';
                }
            }
        }

        return $queryResult;
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    public static function getPage($url)
    {
        if (strpos($url, 'http') != 0) {
            $url = 'http://' . $url;
        }

        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * @param $page
     * @param $type
     * @param null $text
     *
     * @return array
     */
    public static function doSearch($page, $type, $text = null)
    {
        $pattern = false;
        $result = [];

        switch ($type) {
            case 'link':
                $pattern = "/<a[\s]{1}[^>]*href[^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>(.+?)<\/a>/i";

                break;
            case 'image':
                $pattern = "/<img[\s]{1}[^>]*src[^=]*=[ '\"\s]*([^ \"'>\s#]+)[^>]*>/i";

                break;
            case 'text':
                if ($text !== null) {
                    $pattern = '/' . preg_quote($text) . '/';
                }

                break;
        }

        if ($pattern) {
            preg_match_all($pattern, $page, $result);
        }

        return $result;
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    private static function validateParams($params)
    {
        $result['error'] = false;

        $urlPattern = "/^((https?):\/\/)?(www.)?([a-zа-я0-9]+\.)+[a-zа-я]{2,}(:\d+)?\/?$/i";

        if (empty($params['url']) || !preg_match_all($urlPattern, $params['url'])) {
            $result['error'] = true;
            $result['description'] = 'Укажите корректный адрес сайта';
        }

        if (!in_array($params['search_type'], ['text', 'image', 'link'])) {
            $result['error'] = true;
            $result['description'] = 'Укажите корректный тип поиска';
        }

        if ($params['search_type'] == static::SEARCH_TEXT && empty($params['search_text'])) {
            $result['error'] = true;
            $result['description'] = 'Укажите текст для поиска';
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'url_id' => $this->url_id,
            'found' => $this->found,
            'count' => $this->count,
        ];
    }

    /**
     * @return mixed
     */
    public static function findAll()
    {
        $urlTable = Url::getTableName();
        $table = static::getTableName();

        $stmt = self::getConnection()->prepare("SELECT $table.id, $table.count, $table.found, $urlTable.url AS url FROM $table LEFT JOIN $urlTable ON $urlTable.id = $table.url_id");

        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach ($result as $key => $value) {
            $found = unserialize($value['found']);

            $result[$key]['found'] = implode('<br/>', $found);
        }

        return $result;
    }
}
