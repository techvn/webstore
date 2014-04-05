<?php

namespace Posts\Model;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class Collection extends AbstractTable
{
    protected $name = 'mds_categories';
    
    public function init(){
    	
        $this->category();
    }
    
    public function category()
    {
        $select = $this->select(
            function (Select $select) {
                $select->order('created_at');
            }
        );
        $rows  = $this->fetchAll($select);

        $users = array();
        foreach ($rows as $row) {
            $category[] = Model::fromArray((array) $row);
        }
        $this->setData('categories', $category);
    }
    public function  getcategory(){
        return $this->getData('categories');
    }
    /*edit start*/
    public function parrent(){
       //$parrentId = \MDS\Registry::get('Application')->getMvcEvent()->getRouteMatch()->getParam('id',null);
        $parrentId    = $this->getRouteMatch()->getParam('id', null);
         $select = $this->select(
            function (Select $select) {
                $select->where->notEqualTo('id', $parrentId);
            }
        );
         $parrentarray = array();
         $rows  = $this->fetchAll($select);
         foreach ($rows as $val){
         	
             $parrentarray[] = Model::fromArray((array) $rows);
         }
         $this->setData('parrentarray', $parrentarray);
        
    }
}