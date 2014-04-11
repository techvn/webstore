<?php
namespace MDS\Mvc\Service;

use MDS\Module\Collection as ModuleCollection;
use Zend\ModuleManager\Listener;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\Loader\AutoloaderFactory;

class ModuleManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        //$moduleCollection = new ModuleCollection();
        $website_core = $serviceLocator->get('Config');

        $core = $website_core['core'];
        $modules = $core['website'][$core['default']]['module'];
        $website = $core['website'][$core['default']]['type'];

        $array            = array();
        $autoloader       = AutoloaderFactory::getRegisteredAutoloader(AutoloaderFactory::STANDARD_AUTOLOADER);
        foreach ($modules as $module) {
            $array[] = $module['name'];
            $autoloader->registerNamespace(
                $module['name'],
                PATH . '/apps/websites/'.$website.'/' . $module['name']
            );
        }
        $autoloader->register();
        $application   = $serviceLocator->get('Application');
        $configuration = $serviceLocator->get('ApplicationConfig');
        $configuration['module_listener_options']['module_paths'] = array('./apps/'.$website);
        $listenerOptions  = new Listener\ListenerOptions($configuration['module_listener_options']);
        $defaultListeners = new Listener\DefaultListenerAggregate($listenerOptions);
        $serviceListener  = new Listener\ServiceListener($serviceLocator);

        $serviceListener->addServiceManager(
            $serviceLocator,
            'service_manager',
            'Zend\ModuleManager\Feature\ServiceProviderInterface',
            'getServiceConfig'
        );

        $serviceListener->addServiceManager(
            'ControllerLoader',
            'controllers',
            'Zend\ModuleManager\Feature\ControllerProviderInterface',
            'getControllerConfig'
        );
        $serviceListener->addServiceManager(
            'ControllerPluginManager',
            'controller_plugins',
            'Zend\ModuleManager\Feature\ControllerPluginProviderInterface',
            'getControllerPluginConfig'
        );
        $serviceListener->addServiceManager(
            'ViewHelperManager',
            'view_helpers',
            'Zend\ModuleManager\Feature\ViewHelperProviderInterface',
            'getViewHelperConfig'
        );
        $serviceListener->addServiceManager(
            'ValidatorManager',
            'validators',
            'Zend\ModuleManager\Feature\ValidatorProviderInterface',
            'getValidatorConfig'
        );
        $serviceListener->addServiceManager(
            'FilterManager',
            'filters',
            'Zend\ModuleManager\Feature\FilterProviderInterface',
            'getFilterConfig'
        );
        $serviceListener->addServiceManager(
            'FormElementManager',
            'form_elements',
            'Zend\ModuleManager\Feature\FormElementProviderInterface',
            'getFormElementConfig'
        );
        $serviceListener->addServiceManager(
            'RoutePluginManager',
            'route_manager',
            'Zend\ModuleManager\Feature\RouteProviderInterface',
            'getRouteConfig'
        );
        $serviceListener->addServiceManager(
            'SerializerAdapterManager',
            'serializers',
            'Zend\ModuleManager\Feature\SerializerProviderInterface',
            'getSerializerConfig'
        );
        $serviceListener->addServiceManager(
            'HydratorManager',
            'hydrators',
            'Zend\ModuleManager\Feature\HydratorProviderInterface',
            'getHydratorConfig'
        );
        $serviceListener->addServiceManager(
            'InputFilterManager',
            'input_filters',
            'Zend\ModuleManager\Feature\InputFilterProviderInterface',
            'getInputFilterConfig'
        );
        $moduleManager = new ModuleManager($array, $application->getEventManager());
        $moduleManager->getEventManager()->attachAggregate($defaultListeners);
        $moduleManager->getEventManager()->attachAggregate($serviceListener);
        $moduleManager->loadModules();

        $config = $moduleManager->getEvent()->getConfigListener()->getMergedConfig(false);
        if (isset($config['router']['routes'])) {
            $router = $serviceLocator->get('Router');
            $routes = isset($config['router']['routes']) ? $config['router']['routes'] : array();

            $router->getRoute('module')->addRoutes($routes);
        }

        if (is_array($config) && isset($config['view_manager'])) {
            $viewManagerConfig = $config['view_manager'];
            $templatePathStack = $serviceLocator->get('ViewTemplatePathStack');
          //  $coreConfig        = $serviceLocator->get('CoreConfig');
            $templatePathStack->setUseStreamWrapper((bool) true);

            if (is_array($viewManagerConfig)) {
                if (isset($viewManagerConfig['template_path_stack'])) {
                    $templatePathStack->addPaths($viewManagerConfig['template_path_stack']);
                }
                if (isset($viewManagerConfig['default_template_suffix'])) {
                    $templatePathStack->setDefaultSuffix($viewManagerConfig['default_template_suffix']);
                }
            }
        }

        foreach ($moduleManager->getLoadedModules() as $module) {
            if (method_exists($module, 'onBootstrap')) {

                $module->onBootstrap($application->getMvcEvent());
            }
        }
        return $moduleManager;
    }
}
