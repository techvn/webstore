<?php
namespace MDS\Mvc;

abstract class Module
{
   
    protected $directory = null;

    
    protected $namespace = null;

    protected $config;
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                $this->getDir() . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    $this->getNamespace() => $this->getDir() . '/src/' . $this->getNamespace(),
                ),
            ),
        );
    }

   
    public function getConfig()
    {
        if (empty($this->config)) {
            $config       = include $this->getDir() . '/config/module.config.php';
            $this->config = $config;
        }

        return $this->config;
    }

   
    protected function getDir()
    {
        return $this->directory;
    }

    
    protected function getNamespace()
    {
        return $this->namespace;
    }
}
