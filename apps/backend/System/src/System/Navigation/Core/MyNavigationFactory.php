<?php
namespace System\Navigation\Core\Navbar;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class MyNavigationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation =  new MyNavigation();
        return $navigation->createService($serviceLocator);
    }
}
