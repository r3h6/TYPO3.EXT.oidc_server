<?php
declare(strict_types = 1);

return [
    \R3H6\OidcServer\Domain\Model\User::class => [
        'tableName' => 'fe_users',
        'properties' => [
            'identifier' => [
                'fieldName' => 'uid'
            ],
        ],
    ],
];
