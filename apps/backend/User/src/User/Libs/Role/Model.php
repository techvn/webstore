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

namespace User\Libs\Role;

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
    /**
     * Table name
     *
     * @var string
     */
    protected $name = 'mds_user_acl_role';

    /**
     * Protected role name
     *
     * @var string $protectedname
     */
    const PROTECTED_NAME = 'Admin';

    /**
     * Save Role
     *
     * @return integer
     */
    public function save()
    {
        $this->events()->trigger(__CLASS__, 'before.save', null, array('object' => $this));
        $arraySave = array(
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        );

        try {
            $roleId = $this->getId();
            if (empty($roleId)) {
                $this->insert($arraySave);
                $this->setId($this->getLastInsertId());
            } else {
                $this->update($arraySave, array('id' => $this->getId()));
            }

            $permissions = $this->getPermissions();
            if (!empty($permissions)) {
                $aclTable = new TableGateway('user_acl', $this->getAdapter());
                $aclTable->delete(array('mds_user_acl_role_id' => $this->getId()));

                foreach ($permissions as $permissionId => $value) {
                    if (!empty($value)) {
                        $aclTable->insert(
                            array(
                                'user_acl_role_id' => $this->getId(),
                                'user_acl_permission_id' => $permissionId
                            )
                        );
                    }
                }
            }

            $this->events()->trigger(__CLASS__, 'after.save', null, array('object' => $this));

            return $this->getId();
        } catch (\Exception $e) {
            $this->events()->trigger(__CLASS__, 'after.save.failed', null, array('object' => $this));
            throw new \Gc\Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Delete Role
     *
     * @return boolean
     */
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

    /**
     * Initiliaze from array
     *
     * @param array $array Data
     *
     * @return \Gc\User\Role\Model
     */
    public static function fromArray(array $array)
    {
        $roleTable = new Model();
        $roleTable->setData($array);
        $roleTable->setOrigData();

        return $roleTable;
    }

    /**
     * Initiliaze from id
     *
     * @param integer $userRoleId User role id
     *
     * @return \Gc\User\Role\Model
     */
    public static function fromId($userRoleId)
    {
        $roleTable = new Model();
        $row       = $roleTable->fetchRow($roleTable->select(array('id' => (int) $userRoleId)));
        $roleTable->events()->trigger(__CLASS__, 'before.load', null, array('object' => $roleTable));
        if (!empty($row)) {
            $roleTable->setData((array) $row);
            $roleTable->setOrigData();
            $roleTable->events()->trigger(__CLASS__, 'after.load', null, array('object' => $roleTable));
            return $roleTable;
        } else {
            $roleTable->events()->trigger(__CLASS__, 'after.load.failed', null, array('object' => $roleTable));
            return false;
        }
    }

    /**
     * Get User permissions
     *
     * @return array
     */
    public function getUserPermissions()
    {
        $userPermissions = $this->getData('user_permissions');
        if (empty($userPermissions)) {
            $select = new Select();
            if ($this->getName() === self::PROTECTED_NAME) {
                $select->from('mds_user_acl_resource')
                    ->join(
                        'mds_user_acl_permission',
                        'mds_user_acl_resource.id = mds_user_acl_permission.user_acl_resource_id',
                        array(
                            'userPermissionId' => 'id',
                            'permission'
                        )
                    );
            } else {
                $select->from('mds_user_acl_role')
                    ->join(
                        'mds_user_acl',
                        'mds_user_acl.user_acl_role_id = mds_user_acl_role.id',
                        array()
                    )->join(
                        'mds_user_acl_permission',
                        'mds_user_acl_permission.id = mds_user_acl.user_acl_permission_id',
                        array(
                            'userPermissionId' => 'id',
                            'permission'
                        )
                    )->join(
                        'mds_user_acl_resource',
                        'mds_user_acl_resource.id = mds_user_acl_permission.user_acl_resource_id',
                        array('resource')
                    );
                $select->where->equalTo('mds_user_acl_role.id', $this->getId());
            }

            $permissions     = $this->fetchAll($select);
            $userPermissions = array();
            foreach ($permissions as $permission) {
                if (empty($userPermissions[$permission['resource']])) {
                    $userPermissions[$permission['resource']] = array();
                }

                $userPermissions[$permission['resource']][$permission['userPermissionId']] = $permission['permission'];
            }

            $this->setData('user_permissions', $userPermissions);
        }

        return $userPermissions;
    }
}
