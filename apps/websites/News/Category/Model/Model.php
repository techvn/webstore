<?php
///mod_article_categories
namespace Category\Model;
use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\Expression;
class Model extends AbstractTable{
    protected $name = 'mod_article_categories';

    public function getList(){
        $driverName = $this->getDriverName();
        return $this->select(
            function (Select $select) use ($driverName) {
                $select->order('id DESC');
            }
        )->toArray();
    }
}