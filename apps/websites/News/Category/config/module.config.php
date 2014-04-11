<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'CategoryController' => 'Category\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'category' => __DIR__ . '/../views',
        ),
    ),
    'router' => array(
        'routes' => array(
            'category' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route' => '/category',
                    'defaults' => array(
                        'module'     =>'Category',
                        'controller' => 'CategoryController',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'index' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route' => '/edit/:id',
                            'defaults' => array(
                                'module'     =>'Category',
                                'controller' => 'CategoryController',
                                'action'     => 'edit',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
