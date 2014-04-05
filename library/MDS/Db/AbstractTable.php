<?php
namespace MDS\Db;

use MDS\Core\Object;
use MDS\Event\StaticEventManager;
use MDS\Registry;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway;
use Zend\Db\Sql\Select;
use PDO;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;
abstract class AbstractTable extends Object
{
    static protected $tables = array();
    public function __construct()
    {
        if (!empty($this->name) and !array_key_exists($this->name, self::$tables)) {
            self::$tables[$this->name] = new TableGateway\TableGateway(
                $this->name,
                TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter()
            );
        }
        $this->init();
    }
    public function __call($method, $args)
    {
        if (empty(self::$tables[$this->name])) {
            $this->__construct();
        }

        if (method_exists(self::$tables[$this->name], $method)) {
            return call_user_func_array(array(self::$tables[$this->name], $method), $args);
        }

        return parent::__call($method, $args);
    }
    public function fetchRow($query, $parameters = null)
    {
        if ($query instanceof ResultSet) {
            
            $resultSet = $query;
        } else {
            $resultSet = new ResultSet();
            $resultSet->initialize($this->execute($query, $parameters));
        }

        $result = $resultSet->getDataSource()->getResource()->fetch(PDO::FETCH_ASSOC);
        $resultSet->getDataSource()->getResource()->closeCursor();

        return $result;
    }
    public function fetchAll($query, $parameters = null)
    {
        if ($query instanceof ResultSet) {
            $resultSet = $query;
        } else {
            $resultSet = new ResultSet();
            $resultSet->initialize($this->execute($query, $parameters));
        }

        $result = $resultSet->getDataSource()->getResource()->fetchAll(PDO::FETCH_ASSOC);
        $resultSet->getDataSource()->getResource()->closeCursor();

        return $result;
    }
    public function fetchOne($query, $parameters = null)
    {
        if ($query instanceof ResultSet) {
            $resultSet = $query;
        } else {
            $resultSet = new ResultSet();
            $resultSet->initialize($this->execute($query, $parameters));
        }

        $result = $resultSet->getDataSource()->getResource()->fetchColumn();
        $resultSet->getDataSource()->getResource()->closeCursor();

        return $result;
    }
    public function bildPagination(&$order_by,&$order,&$page,$_itemsPerPage=1,$pageRange = 7){
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
    public function execute($query, $parameters = null)
    {
        if (is_string($query)) {
            $statement = $this->getAdapter()->createStatement($query);
        } else {
            $statement = $this->getAdapter()->createStatement();
            $query->prepareStatement($this->getAdapter(), $statement);
        }

        return $statement->execute($parameters);
    }

    
    public function getLastInsertId($tableName = null)
    {
        $tableName = empty($tableName) ? $this->name : $tableName;
        if ($this->getDriverName() == 'pdo_pgsql') {
            $row = $this->fetchRow(sprintf("SELECT currval('%s_id_seq') AS value", $tableName));
            return $row['value'];
        }

        return $this->getAdapter()->getDriver()->getConnection()->getLastGeneratedValue($tableName);
    }

    
    public function events()
    {
        return StaticEventManager::getInstance();
    }

    
    public function getDriverName()
    {
        $configuration = $this->getAdapter()->getDriver()->getConnection()->getConnectionParameters();
        return $configuration['driver'];
    }
}
