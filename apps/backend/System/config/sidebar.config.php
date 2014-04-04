<?php
return array (
    'User' =>
        array (
            'id' => '1',
            'name' => 'User',
            'icon' => 'icon-archive',
            'label' => 'User',
            'route' => 'user/user-manager',
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
                )
            ),
        ),
);
