<?php
namespace User\Libs\Acl;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class Model extends AbstractTable
{
	protected $name = 'mds_user_acl';
	public static function check($user_acl_permission_id,$user_acl_role_id){
		$Table = new Model();
		$select = $Table->select(
			function(Select $select) use($user_acl_permission_id,$user_acl_role_id){
				$select->where(array(
					"user_acl_permission_id"=>$user_acl_permission_id,
					"user_acl_role_id" => $user_acl_role_id
					));
			}
		);
		$row       = $Table->fetchRow($select);

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
	public function save(){
        $this->events()->trigger(__CLASS__, 'before.save', null, array('object' => $this));
        $arraySave = array(
            'user_acl_permission_id' => $this->getUserAclPermissionId(),
            'user_acl_role_id' => $this->getUserAclRoleId(),
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
            throw new \MDS\Exception($e->getMessage(), $e->getCode(), $e);
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
}