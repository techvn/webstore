<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace System;
use MDS\Mvc;
use Zend\EventManager\EventInterface;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\Adapter\Adapter as DbAdapter;
class Module extends Mvc\Module
{
    protected $directory = __DIR__;
    protected $namespace = __NAMESPACE__;
    public function onBootstrap(EventInterface $e)
    {
        $application    = $e->getApplication();
        $config         = $application->getConfig();
        $serviceManager = $application->getServiceManager();
        if (isset($config['db'])) {
            $dbAdapter = $this->initDatabase($config);
        }
       // $application->getEventManager()->attach('render', array($this, 'setLayoutTitle'));
        $this->initSetLayout($e);
    }
    public function initDatabase(array $config)
    {
        $dbAdapter = new DbAdapter($config['db']);
        GlobalAdapterFeature::setStaticAdapter($dbAdapter);
    }
    private function getLayout($_array,$key){
        $rs = 'Front';
        while(true){
            $value = $_array[$key];
            if(strpos($value,'/')){
                $rs = $key;
                break;
            }
            $key = $_array[$key];
        }
        return $rs;
    }
    public function initSetLayout(EventInterface $e){
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($e) {
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');
            $moduleNamespace = $this->getLayout($config['module_layouts'],$moduleNamespace);
            $controller->layout($config['module_layouts'][$moduleNamespace]);
        }, 100);
    }
    public function setLayoutTitle($e)
    {
        $matches    = $e->getRouteMatch();
        $action     = $matches->getParam('action');
        $controller = $matches->getParam('controller');
        $module     = __NAMESPACE__;
        $siteName   = 'Zend Framework';

        // Getting the view helper manager from the application service manager
        $viewHelperManager = $e->getApplication()->getServiceManager()->get('viewHelperManager');

        // Getting the headTitle helper from the view helper manager
        $headTitleHelper   = $viewHelperManager->get('headTitle');

        // Setting a separator string for segments
        $headTitleHelper->setSeparator(' - ');

        // Setting the action, controller, module and site name as title segments
        $headTitleHelper->append($action);
        $headTitleHelper->append($controller);
        $headTitleHelper->append($module);
        $headTitleHelper->append($siteName);
    }
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Navbar' => 'System\Navigation\Core\Navbar\MyNavbarFactory'
            )
        );
    }
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'menu_drop_list'   => function ($pm) {
                    return new \System\Helpers\Select\MenuDropList(

                    );
                }
            )
        );
    }
}