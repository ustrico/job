<?php

return array(
    'type'      => 'group',
    'resolvers' => array(
        
        'default' => array(
            'type'     => 'pattern',
            'path'     => '(<processor>(/<action>))',
            'defaults' => array(
                'processor' => 'tasks',
                'action'    => 'default'
            )
        ),

        'edit' => array(
            'type'     => 'pattern',

            'path'     => 'tasks/edit/<id>',
            'defaults' => array(
                'processor' => 'tasks',
                'action'    => 'default'
            )
        ),

        'view' => array(
            'type'     => 'pattern',

            'path'     => 'tasks/view/<id>',
            'defaults' => array(
                'processor' => 'tasks',
                'action'    => 'view'
            )
        ),

        'list' => array(
            'type'     => 'pattern',

            'path'     => 'tasks/list/<id>',
            'defaults' => array(
                'processor' => 'tasks',
                'action'    => 'list'
            )
        ),

        'excel' => array(
            'type'     => 'pattern',

            'path'     => 'tasks/excel/<view>',
            'defaults' => array(
                'processor' => 'tasks',
                'action'    => 'excel'
            )
        ),

        'price' => array(
            'type'     => 'pattern',
            'path'     => 'price/<action>',
            'defaults' => array(
                'processor' => 'price',
                'action'    => 'default'
            )
        ),

        'login' => array(
            'type'     => 'pattern',
            'path'     => 'login/<action>',
            'defaults' => array(
                'processor' => 'login',
                'action'    => 'default'
            )
        ),
        
    ),
);
