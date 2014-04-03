<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 3/30/14
 * Time: 9:19 AM
 * To change this template use File | Settings | File Templates.
 */
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new \stdClass();
    }
}