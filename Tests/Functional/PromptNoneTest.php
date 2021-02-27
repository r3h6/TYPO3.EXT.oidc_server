<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Tests\Functional;

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
    use \R3H6\Oauth2Server\Tests\Functional\FunctionalTestHelper;

    /**
     * @test
     */
    public function promptNoneReturnsErrorIfNotAuthenticated()
    {
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
