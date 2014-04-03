<?php

namespace User\Model;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class Collection extends AbstractTable
{
    protected $name = 'mds_user';
    public function setUsers()
    {
        $select = $this->select(
            function (Select $select) {
                $select->order('fullname');
            }
        );
        $rows  = $this->fetchAll($select);

        $users = array();
        foreach ($rows as $row) {
            $users[] = Model::fromArray((array) $row);
        }
        $this->setData('users', $users);
    }
    public function  getUser(){
        return $this->getData('users');
    }
}