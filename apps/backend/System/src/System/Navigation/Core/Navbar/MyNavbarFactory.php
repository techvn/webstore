<?php
namespace System\Navigation\Core\Navbar;
 
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
 
class MyNavbarFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $navigation =  new MyNavbar();
        return $navigation->createService($serviceLocator);
    }
}
