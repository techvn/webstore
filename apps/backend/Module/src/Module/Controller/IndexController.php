<?php
namespace Module\Controller;
use MDS\Mvc\Controller\Action;
use Zend\Db\Sql;
use Zend\Filter;
use Zend\Json\Json;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;

class IndexController extends Action
{
    protected $aclPage = array('resource' => 'modules');
    public function indexAction()
    {
        return array();
    }
    public function installAction()
    {
        return array();
    }
    public function uninstallAction()
    {
        return array();
    }
}
