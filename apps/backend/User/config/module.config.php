<?php
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage;
use User\Libs\Model as UserModel;
return array(
    'service_manager' => array(
        'factories' => array(
            'Auth'=> function ($sm) {
                return new AuthenticationService(new Storage\Session(UserModel::BACKEND_AUTH_NAMESPACE));
            },
    )),
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Index' => 'User\Controller\IndexController',
            'User\Controller\UserManager' => 'User\Controller\UserManagerController',
            'User\Controller\Role'=>'User\Controller\RoleController',
            'User\Controller\Permission' => 'User\Controller\PermissionController',
            'User\Controller\Resource'=>'User\Controller\ResourceController',
            'User\Controller\Acl'=>'User\Controller\AclController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/system/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
                        'module'=>'user',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
//                    'default' => array(
//                        'type'    => 'Segment',
//                        'options' => array(
//                            'route'    => '/[:controller[/:action]]',
//                            'constraints' => array(
//                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
//                            ),
//                            'defaults' => array(
//                            ),
//                        ),
//                    ),
                    'login' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/login[/:action][/:redirect]',
                            'constraints' => array(

                            ),
                            'defaults' => array(

                                'controller' => 'User\Controller\Index',
                                'action'     => 'Login',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/edit[/:id]',
                            'constraints' => array(

                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\UserManager',
                                'action'     => 'edit',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/logout',
                            'constraints' => array(

                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Index',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'user-manager' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/user-manager[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'module'=>'user',
                                'controller' => 'User\Controller\UserManager',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'resource-manager' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/resource[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'User\Controller\Resource',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'role-manager' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/role[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'module'=>'user',
                                'controller' => 'User\Controller\Role',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'permission-manager' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/permission[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'module'=>'user',
                                'controller' => 'User\Controller\Permission',
                                'action'     => 'index',
                                'order_by'=>'id',
                                'order'=>'ASC'
                            ),
                        ),
                    ),
                    'acl-role' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/acl-role[/:id]',
                            'constraints' => array(

                            ),
                            'defaults' => array(
                                'module'=>'user',
                                'controller' => 'User\Controller\Acl',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
);
