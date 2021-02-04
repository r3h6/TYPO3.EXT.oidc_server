<?php

namespace R3H6\OidcServer\Tests\Functional;

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
        'LOG' => [
            'R3H6' => [

                    'writerConfiguration' => [
                        \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
                            \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [],
                        ]
                    ]

            ],
            'TYPO3' => [
                'CMS' => [
                    'Frontend' => [
                        'Authentication' => [
                            'writerConfiguration' => [
                                \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
                                    \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                                        'logFile' =>  'typo3temp/var/log/auth.log'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet('EXT:oidc_server/Tests/Fixtures/Database/pages.xml');
        $this->setUpFrontendRootPage(1);
    }
}
