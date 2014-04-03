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
}
