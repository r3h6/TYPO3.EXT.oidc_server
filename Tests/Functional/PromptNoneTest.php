<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Tests\Functional;

use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequestContext;

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

class PromptNoneTest extends ApplicationTestCase
{
    /**
     * @test
     */
    public function promptNoneReturnsErrorIfNotAuthenticated(): void
    {
        $request = new InternalRequest('https://localhost/oauth2/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => 'test0000-0000-0000-0000-000000000001',
            'redirect_uri' => 'https://localhost/redirect',
            'state' => 'bwqjmz2j2gs',
            'scope' => 'openid',
            'prompt' => 'none',
        ]));
        $context = new InternalRequestContext();
        $response = $this->executeFrontendSubRequest($request, $context);

        $json = json_decode((string)$response->getBody(), true);
        self::assertSame('login_required', $json['error'], 'Response: ' . $response->getBody());
    }
}
