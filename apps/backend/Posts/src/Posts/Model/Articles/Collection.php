<?php
namespace Posts\Model\Articles;
use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class Collection extends AbstractTable
{
    protected $name = 'mds_articles';
    public function init()
    {
        $this->setArticles();
    }

    public function getArticles()
    {
        return $this->getData('articles');
    }

    protected function setArticles()
    {
        $select = $this->select(
            function (Select $select) {
                $select->order('title');
            }
        );
        $rows  = $this->fetchAll($select);
        $articles = array();
        foreach ($rows as $row) {
            $articles[] = Model::fromArray((array) $row);
        }
        $this->setData('articles', $articles);
    }
}
