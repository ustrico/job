<?php
define('year', 2016);
define('months', '01=Jan|02=Feb|03=Mar|04=Apr|05=May|06=Jun|07=Jul|08=Aug|09=Sep|10=Oct|11=Nov|12=Dec');
return array(
    'translator' => array(
        'basePath' => '/'
    ),
    'resolver' => array(
        'type' => 'group',
        'resolvers' => array(
            'app' => array(
                'type' => 'prefix',
                'defaults' => array(
                    'bundle' => 'app'
                ),
                'resolver' => array(
                    'type' => 'mount',
                    'name' => 'app'
                )
            )
        )
    ),
    'exceptionResponse' => array(
        'template' => 'framework:http/exception'
    ),
    'notFoundResponse' => array(
        'template' => 'framework:http/notFound'
    )
);