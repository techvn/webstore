<?php

namespace Posts\Model;

use MDS\Db\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
use Zend\Db\Sql\Predicate\Expression;

class Model extends AbstractTable
{
    protected $name = 'mds_categories';
    
    public static function fromArray(array $array)
    {
        $mds_user = new Model();
        $mds_user->setData($array);
        $mds_user->setOrigData();
        return $mds_user;
    }
    
      
    public function save()
    {
    	$this->events()->trigger(__CLASS__, 'before.save', $this);
    	$arraySave = array(
    	        'parrent_id' => $this->getParrentId(),
    			'title' => $this->getTitle(),
        	    'slug' => $this->getSlug(),
        	    'active' => $this->getActive(),
        	    'metakey' => $this->getMetakey(),
        	    'metades' => $this->getMetades()
    	);
    
    	try {
    		$moduleId = $this->getId();
    		if (empty($moduleId)) {
    			$arraySave['created_at'] = new Expression('NOW()');
    			$this->insert($arraySave);
    			$this->setId($this->getLastInsertId());
    		} else {
    		    $arraySave['updated_at'] = new Expression('NOW()');
    			$this->update($arraySave, array('id' => $this->getId()));
    		}
    
    		$this->events()->trigger(__CLASS__, 'after.save', $this);
    
    		return $this->getId();
    	} catch (\Exception $e) {
    		$this->events()->trigger(__CLASS__, 'after.save.failed', $this);
    		throw new \MDS\Exception($e->getMessage(), $e->getCode(), $e);
    	}
    }
    
    
    
    
    
    
    
    
    
    
    public function delete()
    {
        $this->events()->trigger(__CLASS__, 'before.delete', $this);
        $categoryId = $this->getId();
        if (!empty($categoryId)) {
            try {
                parent::delete(array('id' => $categoryId));
            } catch (\Exception $e) {
                throw new \MDS\Exception($e->getMessage(), $e->getCode(), $e);
            }

            $this->events()->trigger(__CLASS__, 'after.delete', $this);
            unset($this);

            return true;
        }

        $this->events()->trigger(__CLASS__, 'after.delete.failed', $this);

        return false;
    }
    
    public static function fromId($moduleId)
    {
    	$moduleTable = new Model();
    	$row         = $moduleTable->fetchRow($moduleTable->select(array('id' => (int) $moduleId)));
    	$moduleTable->events()->trigger(__CLASS__, 'before.load', $moduleTable);
    	if (!empty($row)) {
    		$moduleTable->setData((array) $row);
    		$moduleTable->setOrigData();
    		$moduleTable->events()->trigger(__CLASS__, 'after.load', $moduleTable);
    		return $moduleTable;
    	} else {
    		$moduleTable->events()->trigger(__CLASS__, 'after.load.failed', $moduleTable);
    		return false;
    	}
    }
    
    
    
    
    
}