<?php


namespace User\Libs\Resource;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
class Model extends AbstractTable
{
    protected $name = 'mds_user_acl_resource';
    public function save()
    {
        $this->events()->trigger(__CLASS__, 'before.save', null, array('object' => $this));
        $arraySave = array(
            'firstname' => $this->getFirstname(),
            'lastname' => $this->getLastname(),
            'email' => $this->getEmail(),
            'login' => $this->getLogin(),
            'updated_at' => new Expression('NOW()'),
            'user_acl_role_id' => $this->getUserAclRoleId(),
            'retrieve_password_key' => $this->getRetrievePasswordKey(),
            'retrieve_updated_at' => $this->getRetrieveUpdatedAt(),
        );

        $password = $this->getPassword();
        if (!empty($password)) {
            $arraySave['password'] = $password;
        }
        try {
            $id = $this->getId();
            if (empty($id)) {
                $arraySave['created_at'] = new Expression('NOW()');
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
        $roleTable = new Model();
        $roleTable->setData($array);
        $roleTable->setOrigData();
        return $roleTable;
    }
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
}
