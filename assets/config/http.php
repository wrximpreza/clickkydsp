<?php

return array(
    'translator' => array(
        'basePath' => '/web/'
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