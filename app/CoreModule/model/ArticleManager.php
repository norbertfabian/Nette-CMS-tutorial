<?php
/**
 * Created by PhpStorm.
 * User: mathesio
 * Date: 14.03.2018
 * Time: 10:45
 */

namespace App\CoreModule\Model;

use App\Model\BaseManager;
use Nette\Database\Table\Selection;
use Nette\Database\Table\IRow;

class ArticleManager extends BaseManager
{

    const
        TABLE_NAME = 'article',
        COLUMN_ID = 'article_id',
        COLUMN_URL = 'url';

    /**
     * @return Selection
     */
    public function getArticles()
    {
        return $this->database->table(self::TABLE_NAME)->order(self::COLUMN_ID . ' DESC');
    }

    /**
     * @param $url
     * @return bool|mixed|IRow
     */
    public function getArticle($url)
    {
        return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_URL, $url)->fetch();
    }

    /**
     * @param $article
     */
    public function saveArticle($article)
    {
        if (!$article[self::COLUMN_ID])
            $this->database->table(self::TABLE_NAME)->insert($article);
        else
            $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $article[self::COLUMN_ID])->update($article);
    }

    /**
     * @param $url
     */
    public function removeArticle($url)
    {
        $this->database->table(self::TABLE_NAME)->where(self::COLUMN_URL, $url)->delete();
    }


}