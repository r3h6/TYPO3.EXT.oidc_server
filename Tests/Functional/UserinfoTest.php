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

class UserinfoTest extends ApplicationTestCase
{
    /**
     * @test
     */
    public function userinfoEndpointReturnsAccessDeniedIfNotAuthenticated(): void
    {
        $request = new InternalRequest('https://localhost/oauth2/userinfo');
        $context = new InternalRequestContext();
        $response = $this->executeFrontendSubRequest($request, $context);
        self::assertSame(401, $response->getStatusCode());
    }
}
