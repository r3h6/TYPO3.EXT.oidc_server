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
 * UserinfoTest
 */
class UserinfoTest extends FunctionalTestCase
{
    use \R3H6\Oauth2Server\Tests\Functional\FunctionalTestHelper;

    /**
     * @test
     */
    public function clientCredentialsGrant()
    {
        $response = $this->doFrontendRequest(
            'GET',
            'https://localhost/oauth2/userinfo',
            [
                'HTTP_authorization' => 'Bearer ' . $this->createAccessToken([$this->createScopeMock('profile')]),
            ]
        );

        $claims = json_decode((string)$response->getBody(), true);
        self::assertSame(1, $claims['sub']);
        self::assertSame(1612466634, $claims['updated_at']);
        // {"name":"Mr. Kasper Sk\u00e5rh\u00f8j","family_name":"Sk\u00e5rh\u00f8j","given_name":"Kasper","middle_name":"","nickname":"","preferred_username":"user","profile":"","picture":"","website":"https://typo3.org","gender":"","birthdate":"","zoneinfo":"","locale":"","updated_at":1612466634,"sub":1}
        // self::assertSame(' ', (string) $response->getBody());
    }

    /**
     * @test
     */
    public function scopeRoleReturnsRoleClaim()
    {
        $response = $this->doFrontendRequest(
            'GET',
            'https://localhost/oauth2/userinfo',
            [
                'HTTP_authorization' => 'Bearer ' . $this->createAccessToken([$this->createScopeMock('role')]),
            ]
        );

        $claims = json_decode((string)$response->getBody(), true);
        self::assertSame('Oauth2, Oauth2', $claims['Roles']);
    }
}
