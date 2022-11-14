<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "oidc_server"
 *
 * Auto generated by Extension Builder 2021-02-07
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
    'title' => 'OIDC Server',
    'description' => 'OpenID Connect Server.',
    'category' => 'services',
    'author' => '',
    'author_email' => '',
    'state' => 'beta',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.1.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'oauth2_server' => '1.2.0-1.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
