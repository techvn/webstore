<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP Version >=5.3
 *
 * @category   Gc
 * @package    Library
 * @subpackage User
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace User\Libs;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
/**
 * Collection of User Model
 *
 * @category   Gc
 * @package    Library
 * @subpackage User
 */
class Collection extends AbstractTable
{
    /**
     * Table name
     *
     * @var string
     */
    protected $name = 'mds_user';

    /**
     * Initiliaze User collection
     *
     * @return void
     */
    public function init()
    {
        $this->setUsers();
    }

    /**
     * Get users
     *
     * @return array Gc\User\Model
     */
    public function getUsers()
    {

        return $this->getData('users');
    }

    /**
     * Set users collection
     *
     * @return void
     */
    protected function setUsers()
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
