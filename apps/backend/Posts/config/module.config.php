<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'IndexController' => 'Posts\Controller\IndexController',
            'CategoryController' => 'Posts\Controller\CategoryController',
            'ArticlesController' => 'Posts\Controller\ArticlesController',
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
                                                    'route'    => '/[:action][/:id][/page/:page][/order_by/:order_by][/:order][/:redirect]',
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
