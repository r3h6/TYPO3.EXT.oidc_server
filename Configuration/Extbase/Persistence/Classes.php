<?php

declare(strict_types=1);

use R3H6\OidcServer\Domain\Model\User;

return [
    User::class => [
        'tableName' => 'fe_users',
        'properties' => [
            'nickname' => [
                'fieldName' => 'tx_oidcserver_nickname',
            ],
            'gender' => [
                'fieldName' => 'tx_oidcserver_gender',
            ],
            'birthdate' => [
                'fieldName' => 'tx_oidcserver_birthdate',
            ],
            'locale' => [
                'fieldName' => 'tx_oidcserver_locale',
            ],
        ],
    ],
];
