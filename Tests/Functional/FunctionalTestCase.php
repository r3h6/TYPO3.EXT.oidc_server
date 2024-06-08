<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Tests\Functional;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

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
/**
 * FunctionalTestCase
 */
abstract class FunctionalTestCase extends \TYPO3\TestingFramework\Core\Functional\FunctionalTestCase
{
    protected $testExtensionsToLoad = [
        'typo3conf/ext/oauth2_server',
        'typo3conf/ext/oidc_server',
    ];

    protected $pathsToLinkInTestInstance = [
        'typo3conf/ext/oidc_server/Tests/Fixtures/config/sites' => 'typo3conf/sites',
    ];

    protected $configurationToUseInTestInstance = [
        'EXTENSIONS' => [
            'oauth2_server' => [
                'server' => [
                    'consentPageUid' => '1',
                ],
            ],
        ],
        'LOG' => [
            'R3H6' => [
                'writerConfiguration' => [
                    LogLevel::DEBUG => [
                        FileWriter::class => [],
                    ],
                ],
            ],
            'TYPO3' => [
                'CMS' => [
                    'Frontend' => [
                        'Authentication' => [
                            'writerConfiguration' => [
                                LogLevel::DEBUG => [
                                    FileWriter::class => [
                                        'logFile' =>  'typo3temp/var/log/auth.log',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet('EXT:oidc_server/Tests/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(1);
    }
}
