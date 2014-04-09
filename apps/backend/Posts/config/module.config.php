<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Posts\Controller\Index' => 'Posts\Controller\IndexController',
            'Posts\Controller\Category' => 'Posts\Controller\CategoryController',
            'Posts\Controller\Articles' => 'Posts\Controller\ArticlesController',
        ),
    ),
    'view_manager' => array(
    		'template_path_stack' => array(
    				'Posts' => __DIR__ . '/../view',
    		),
    ),
    'router' => array(
        'routes' => array(
            'posts' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/system/posts',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Posts\Controller',
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
                    'article-manager' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/articles[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'module'=>'posts',
                                'controller' => 'Posts\Controller\Articles',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'cate-manager' => array(
                        'type'    => 'Segment',
                        'may_terminate' => true,
                        'options' => array(
                            'route'    => '/category[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'Posts\Controller\Category',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'router1' => array(
        'routes' => array(
            'posts' => array(
            		'type'    => 'Literal',
            		'options' => array(
            				'route'    => '/system/posts',
            				'defaults' =>
            				array (
            						'module'     => 'Posts',
            						'controller' => 'PostsController',
            						'action'     => 'index',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				//Views
            				'category' => array(
            						'type'    => 'Literal',
            						'options' => array(
            								'route'    => '/category',
            								'defaults' =>
            								array (
            										'module'     => 'Category',
            										'controller' => 'CategoryController',
            										'action'     => 'index',
            								),
            						),
            						'may_terminate' => true,
            						'child_routes' => array(
                                            'default' => array(
                                                'type'    => 'Segment',
                                                'options' => array(
                                                    'route'    => '[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                                                    'constraints' => array(
                                                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id'     => '[0-9]+',
                                                        'page' => '[0-9]+',
                                                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'order' => 'ASC|DESC',
                                                    ),
                                                    'defaults' => array(
                                                    ),
                                                ),
                                            ),
            								'create' => array(
            										'type'    => 'Literal',
            										'options' => array(
            												'route'    => '/create',
            												'defaults' =>
            												array (
            														'module'     => 'Category',
            														'controller' => 'CategoryController',
            														'action'     => 'create',
            												),
            										),
            								),
            								'edit' => array(
            										'type'    => 'Segment',
            										'options' => array(
            												'route'    => '/edit/:id',
            												'defaults' =>
            												array (
            														'module'     => 'Category',
            														'controller' => 'CategoryController',
            														'action'     => 'edit',
            												),
            												'constraints' =>
            												array (
            														'id' => '\d+',
            												),
            										),
            								),
             								'delete' => array(
            										'type'    => 'Segment',
            										'options' => array(
            												'route'    => '/delete/:id',
            												'defaults' =>
            												array (
            														'module'     => 'Category',
            														'controller' => 'CategoryController',
            														'action'     => 'delete',
            												),
            												'constraints' =>
            												array (
            														'id' => '\d+',
            												),
            										),
            								),
            						),
            				),
            				'articles' => array(
            						'type'    => 'Literal',
            						'options' => array(
            								'route'    => '/articles',
            								'defaults' =>
            								array (
            										'module'     => 'Articles',
            										'controller' => 'ArticlesController',
            										'action'     => 'index',
            								),
            						),
            						'may_terminate' => true,
            						'child_routes' => array(
                                            'default' => array(
                                                'type'    => 'Segment',
                                                'options' => array(
                                                    'route'    => '[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
                                                    'constraints' => array(
                                                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'id'     => '[0-9]+',
                                                        'page' => '[0-9]+',
                                                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                                        'order' => 'ASC|DESC',
                                                    ),
                                                    'defaults' => array(
                                                    ),
                                                ),
                                            ),
            								'create' => array(
            										'type'    => 'Literal',
            										'options' => array(
            												'route'    => '/create',
            												'defaults' =>
            												array (
            														'module'     => 'Articles',
            														'controller' => 'ArticlesController',
            														'action'     => 'create',
            												),
            										),
            								),
            								'edit' => array(
            										'type'    => 'Segment',
            										'options' => array(
            												'route'    => '/edit/:id',
            												'defaults' =>
            												array (
            														'module'     => 'Articles',
            														'controller' => 'ArticlesController',
            														'action'     => 'edit',
            												),
            												'constraints' =>
            												array (
            														'id' => '\d+',
            												),
            										),
            								),
            								'delete' => array(
            										'type'    => 'Segment',
            										'options' => array(
            												'route'    => '/delete/:id',
            												'defaults' =>
            												array (
            														'module'     => 'Articles',
            														'controller' => 'ArticlesController',
            														'action'     => 'delete',
            												),
            												'constraints' =>
            												array (
            														'id' => '\d+',
            												),
            										),
            								),
            						),
            				),
            		),
            ),

        ),
    ),

);
