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
 * @subpackage User\Role
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace User\Libs\Permission;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

/**
 * Role Model
 *
 * @category   Gc
 * @package    Library
 * @subpackage User\Role
 */
class Model extends AbstractTable
{
    protected $name = 'mds_user_acl_permission';
    public function save(){
        $this->events()->trigger(__CLASS__, 'before.save', null, array('object' => $this));
        
        $arraySave = array(
            'permission' => $this->getPermission(),
            'user_acl_resource_id' => $this->getUserAclResourceId(),
        );
        try {
            $id = $this->getId();
            if (empty($id)) {
                $this->insert($arraySave);
                $this->setId($this->getLastInsertId());
            } else {
                $this->update($arraySave, array('id' => $this->getId()));
            }
            $this->events()->trigger(__CLASS__, 'after.save', null, array('object' => $this));
            return $this->getId();
        } catch (\Exception $e) {
            $this->events()->trigger(__CLASS__, 'after.save.failed', null, array('object' => $this));
            throw new \MyZendTrung\Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
    public function delete()
    {
        $this->events()->trigger(__CLASS__, 'before.delete', null, array('object' => $this));
        $id = $this->getId();
        if (!empty($id)) {
            parent::delete(array('id' => $id));
            $this->events()->trigger(__CLASS__, 'after.delete', null, array('object' => $this));
            unset($this);

            return true;
        }

        $this->events()->trigger(__CLASS__, 'after.delete.failed', null, array('object' => $this));

        return false;
    }

    public static function fromArray(array $array)
    {
        $Table = new Model();
        $Table->setData($array);
        $Table->setOrigData();

        return $Table;
    }
    public static function fromId($id)
    {
        $Table = new Model();
        $row       = $Table->fetchRow($Table->select(array('id' => (int) $id)));
        $Table->events()->trigger(__CLASS__, 'before.load', null, array('object' => $Table));
        if (!empty($row)) {
            $Table->setData((array) $row);
            $Table->setOrigData();
            $Table->events()->trigger(__CLASS__, 'after.load', null, array('object' => $Table));
            return $Table;
        } else {
            $Table->events()->trigger(__CLASS__, 'after.load.failed', null, array('object' => $Table));
            return false;
        }
    }
}
