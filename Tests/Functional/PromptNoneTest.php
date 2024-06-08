<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Tests\Functional;

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * PromptNoneTest
 */
class PromptNoneTest extends FunctionalTestCase
{
    use FunctionalTestHelper;

    /**
     * @test
     */
    public function promptNoneReturnsErrorIfNotAuthenticated(): void
    {
        if (version_compare(GeneralUtility::makeInstance(Typo3Version::class)->getVersion(), '11.5', '>=')) {
            self::markTestSkipped('Needs to be reworked');
        }

        $response = $this->doFrontendRequest(
            'GET',
            '/oauth2/authorize',
            [
                'response_type' => 'code',
                'client_id' => '660e56d72c12f9a1e2ec',
                'redirect_uri' => 'http://localhost/',
                'scope' => 'openid',
                'prompt' => 'none',
            ]
        );

        $json = json_decode((string)$response->getBody(), true);
        self::assertSame('login_required', $json['error']);
    }
}
