<?php
return array (
    'Dashboard' =>
    array (
        'id' => '1',
        'name' => 'Dashboard',
        'icon' => 'icon-archive',
        'label' => 'Dashboard',
        'route' => 'system',
        'params' =>
        array (

        ),
        'resource' => 'content',
        'pages' =>array (
        ),
    ),
    'User' =>
        array (
            'id' => '1',
            'name' => 'User',
            'icon' => 'icon-archive',
            'label' => 'User',
            'route' => 'user',
            'params' =>
             array (
                'action' => 'index'
             ),
            'resource' => 'content',
            'pages' =>array (
                array (
                    'id' => '1',
                    'name' => 'User',
                    'icon' => 'icon-archive',
                    'label' => 'User',
                    'route' => 'user/user-manager',
                    'params' =>array (
                            'action' => 'index'
                     ),
                    'resource' => 'settings',
                    'permission'=>'user/list',
                    'pages' =>array (

                    ),
                ),
                 array (
                     'id' => '2',
                     'name' => 'Permssion',
                     'icon' => 'icon-archive',
                     'label' => 'Permssion',
                     'route' => 'user/permission-manager',
                     'params' =>array (
                         'action' => 'index'
                     ),
                     'resource' => 'settings',
                     'permission'=>'user/list',
                     'pages' =>array (

                     ),
                 ),
                array (
                    'id' => '2',
                    'name' => 'Role',
                    'icon' => 'icon-archive',
                    'label' => 'Role',
                    'route' => 'user/role-manager',
                    'params' =>array (
                        'action' => 'index'
                    ),
                    'resource' => 'settings',
                    'permission'=>'user/list',
                    'pages' =>array (

                    ),
                )
            ),
        ),
    'Post' =>
    array (
        'id' => '1',
        'name' => 'Post',
        'icon' => 'icon-archive',
        'label' => 'Post',
        'route' => 'posts',
        'params' =>
        array (
            'action' => 'index'
        ),
        'resource' => 'content',
        'pages' =>array (
            array (
                'id' => '1',
                'name' => 'Articles',
                'icon' => 'icon-archive',
                'label' => 'Articles',
                'route' => 'posts/article-manager',
                'params' =>array (
                    'action' => 'index'
                ),
                'resource' => 'settings',
                'permission'=>'user/list',
                'pages' =>array (

                ),
            ),
            array (
                'id' => '1',
                'name' => 'Categrory',
                'icon' => 'icon-archive',
                'label' => 'Categrory',
                'route' => 'posts/cate-manager',
                'params' =>array (
                    'action' => 'index'
                ),
                'resource' => 'settings',
                'permission'=>'user/list',
                'pages' =>array (

                ),
            )
        ),
    ),
);
