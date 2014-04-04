<?php
namespace TrungDm\SystemDb\Navigation;
use TrungDm\System\Db\AbstractTable;
use Zend\Db\Sql\Select;
class Model extends AbstractTable
{
	protected $name = 'navigation';
	public static function fromArray(array $array)
    {
        $userTable = new Model();
        $userTable->setData($array);
        $userTable->setOrigData();

        return $userTable;
    }
    public function saveSort()
    {
        $this->events()->trigger(__CLASS__, 'before.save', null, array('object' => $this));
        $arraySave = array(
            'parent_id' => $this->getParentId(),
            'position' => $this->getPosition()
        );
        try {
            $id = $this->getId();
            $this->update($arraySave, array('id' => $this->getId()));
            $this->events()->trigger(__CLASS__, 'after.save', null, array('object' => $this));
            return $this->getId();
        } catch (\Exception $e) {
            $this->events()->trigger(__CLASS__, 'after.save.failed', null, array('object' => $this));
            throw new \Gc\Exception($e->getMessage(), $e->getCode(), $e);
        }
    }
    public function save()
    {
        $this->events()->trigger(__CLASS__, 'before.save', null, array('object' => $this));

        $arraySave = array(
            'name' => $this->getName(),
            'icon' => $this->getIcon(),
            'label' => $this->getName(),
            'route' => $this->getRoute(),
            'params' => serialize($this->getParams()),
            'resource' => $this->getResource(),
            'parent_id' => $this->getCategorie(),
            'active' => $this->getActive(),
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
            try {
                parent::delete(array('id' => $id));
            } catch (\Exception $e) {
                throw new \MyZendTrung\Exception($e->getMessage(), $e->getCode(), $e);
            }
            $this->events()->trigger(__CLASS__, 'after.delete', null, array('object' => $this));
            unset($this);
            return true;
        }

        $this->events()->trigger(__CLASS__, 'after.delete.failed', null, array('object' => $this));

        return false;
    }
    public static function fromId($cateid)
    {
        $CategorieModel = new Model();
        $row       = $CategorieModel->fetchRow($CategorieModel->select(array('id' => (int) $cateid)));
        $CategorieModel->events()->trigger(__CLASS__, 'before.load', null, array('object' => $CategorieModel));
        if (!empty($row)) {
            $CategorieModel->setData((array) $row);
            $CategorieModel->setOrigData();
            $CategorieModel->events()->trigger(__CLASS__, 'after.load', null, array('object' => $CategorieModel));
            return $CategorieModel;
        } else {
            $CategorieModel->events()->trigger(__CLASS__, 'after.load.failed', null, array('object' => $CategorieModel));
            return false;
        }
    }
}