<?php

$container->loadFromExtension('security', [
    'firewalls' => [
        'main' => [
            'form_login' => [
                'login_path' => '/login',
            ],
        ],
    ],
    'role_hierarchy' => [
        'FOO' => 'BAR',
        'ADMIN' => 'USER',
    ],
]);
