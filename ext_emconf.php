<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'OIDC Server',
    'description' => 'OpenID Connect server for TYPO3.',
    'category' => 'services',
    'author' => '',
    'author_email' => '',
    'state' => 'beta',
    'version' => '2.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
            'oauth2_server' => '2.0.0-2.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
