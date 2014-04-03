<?php
namespace MDS\Core;
use MDS\Db\AbstractTable;
use Zend\Db\Sql\Where;
class Config extends AbstractTable
{
    const SESSION_FILES = 0;
    const SESSION_DATABASE = 1;
    protected $name = 'core_config_data';
    public function getValue($data, $field = 'identifier')
    {
        $row = $this->fetchRow($this->select(array($field => $data)));
        if (!empty($row)) {
            return $row['value'];
        }

        return null;
    }
    public function getValues()
    {
        $rows = $this->fetchAll($this->select());
        if (!empty($rows)) {
            return $rows;
        }

        return array();
    }

    public function setValue($identifier, $value)
    {
        if (empty($identifier)) {
            return false;
        }

        $row = $this->fetchRow($this->select(array('identifier' => $identifier)));
        if (!empty($row)) {
            $where = new Where();
            return $this->update(array('value' => $value), $where->equalTo('identifier', $identifier));
        }

        return false;
    }
}
