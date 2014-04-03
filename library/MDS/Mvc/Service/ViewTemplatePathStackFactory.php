<?php
namespace MDS\Mvc\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MDS\View\Resolver\TemplatePathStack;

class ViewTemplatePathStackFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $templatePathStack = new TemplatePathStack();
        $templatePathStack->setUseStreamWrapper(true);
        if (is_array($config) && isset($config['view_manager'])) {
            $config = $config['view_manager'];

            if (is_array($config)) {
                if (isset($config['template_path_stack'])) {
                     
                    $templatePathStack->addPaths($config['template_path_stack']);
                }
                if (isset($config['default_template_suffix'])) {
                    $templatePathStack->setDefaultSuffix($config['default_template_suffix']);
                }
            }
        }
        return $templatePathStack;
    }
}

