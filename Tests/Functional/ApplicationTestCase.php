<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Tests\Functional;

use Symfony\Component\Mailer\Transport\NullTransport;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

/***
 *
 * This file is part of the "OIDC Server" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020
 *
 ***/

abstract class ApplicationTestCase extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/oauth2_server',
        'typo3conf/ext/oidc_server',
    ];

    protected array $pathsToLinkInTestInstance = [
        'typo3conf/ext/oidc_server/Tests/Fixtures/config/sites' => 'typo3conf/sites',
    ];

    protected array $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'oauth2_server' => [
                'loginPageUid' => 1,
                'consentPageUid' => 2,
            ],
        ],
        'MAIL' => [
            'transport' => NullTransport::class,
        ],
        'LOG' => [
            'R3H6' => [
                'writerConfiguration' => [
                    \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
                        \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [],
                    ],
                ],
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importCSVDataSet(__DIR__ . '/../Fixtures/Database/base.csv');
        $this->setUpFrontendRootPage(1, [
            'constants' => ['EXT:oauth2_server/Configuration/TypoScript/constants.typoscript'],
            'setup' => ['EXT:oauth2_server/Configuration/TypoScript/setup.typoscript'],
        ]);
    }
}
