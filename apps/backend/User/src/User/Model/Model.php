<?php

namespace User\Model;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class Model extends AbstractTable
{
    protected $name = 'mds_user';
    public static function fromArray(array $array)
    {
        $mds_user = new Model();
        $mds_user->setData($array);
        $mds_user->unsetData('password');
        $mds_user->setOrigData();
        return $mds_user;
    }
    public function save(){

    }
}