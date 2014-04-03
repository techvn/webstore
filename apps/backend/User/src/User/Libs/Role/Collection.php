<?php
namespace User\Libs\Role;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;

class Collection extends AbstractTable
{

    protected $roles;

    protected $name = 'mds_user_acl_role';

    public function init()
    {
        $this->getRoles(true);
    }

    public function getRoles($forceReload = false)
    {
        if (empty($this->roles) or $forceReload === true) {
            $rows = $this->fetchAll(
                $this->select(
                    function (Select $select) {
                        $select->order('name');
                    }
                    )
                );

            $roles = array();
            foreach ($rows as $row) {
                $roles[] = Model::fromArray((array) $row);
            }

            $this->roles = $roles;
        }

        return $this->roles;
    }
    public function bildPagination($order_by,$order,$page,$_itemsPerPage=1,$pageRange = 7){
        $order_by = $order_by ? $order_by : 'id';
        $order = $order ? $order : Select::ORDER_ASCENDING;
        $page = $page ? (int) $page : 1;

        $select = $this->select(
            function(Select $select) use($order_by,$order){
                $select->order($order_by . ' ' . $order);
            }
            );
        
        $albums = $this->fetchAll($select,null,\PDO::FETCH_OBJ);
        $itemsPerPage = $_itemsPerPage;
        $paginator = new Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($albums));
        $paginator->setCurrentPageNumber($page)
        ->setItemCountPerPage($itemsPerPage)
        ->setPageRange($pageRange);
        return $paginator;
    }
}
