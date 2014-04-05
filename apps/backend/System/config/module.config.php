<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'system' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/system',
                    'defaults' => array(
                        'controller' => 'System\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'system' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/system',
                    'defaults' => array(
                        '__NAMESPACE__' => 'System\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'MyUploadImages' => 'System\Controller\Plugin\MyUploadImages',
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'System\Controller\Index' => 'System\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => array(
        		'system' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'layout/system'           => __DIR__ . '/../view/layouts/priv.phtml',
            'layout/system/paginator' => __DIR__.'/../view/layouts/comp/paginator.phtml',
            'pageheader'           => __DIR__ . '/../view/layouts/comp/pageheader.phtml',
            'breadcrumbs'           => __DIR__ . '/../view/layouts/comp/breadcrumbs.phtml',
            'layout/system/login'           => __DIR__ . '/../view/layouts/login.phtml',
            'layout/system/navbar'           => __DIR__ . '/../view/layouts/comp/navbar.phtml',
            'menuleft'           => __DIR__ . '/../view/layouts/comp/menuleft.phtml',
            'messages'           => __DIR__ . '/../view/layouts/messages.phtml',
            'system/index/index' => __DIR__ . '/../view/system/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'strategies' => array(
        	'ViewJsonStrategy',
        ),
    ),
);
