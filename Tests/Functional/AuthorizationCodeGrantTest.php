<?php

namespace R3H6\OidcServer\Tests\Functional;

class AuthorizationCodeGrantTest extends FunctionalTestCase
{
    use \R3H6\Oauth2Server\Tests\Functional\FunctionalTestHelper;

    /**
     * @test
     */
    public function issuesIdToken()
    {
        $response = $this->doFrontendRequest(
            'GET',
            '/oauth2/authorize',
            [
                'response_type' => 'code',
                'client_id' => '660e56d72c12f9a1e2ec',
                'redirect_uri' => 'http://localhost/',
                'scope' => 'openid',
            ]
        );

        $response = $this->doFrontendRequest(
            'POST',
            '/?logintype=login',
            ['user' => 'user', 'pass' => 'password'],
            $this->getLastCookie()
        );

        $response = $this->doFrontendRequest(
            'POST',
            '/oauth2/authorize',
            [],
            $this->getLastCookie()
        );

        $response = $this->doFrontendRequest(
            'POST',
            '/oauth2/token',
            [
                'grant_type' => 'authorization_code',
                'client_id' => '660e56d72c12f9a1e2ec',
                'client_secret' => 'CCJL1/s3TQLMHj9le2bBUlD7tmkPZKlOTZGgBQRb3BE=',
                'redirect_uri' => 'http://localhost/',
                'code' => $this->getCodeFromResponse($response),
            ]
        );

        $token = json_decode((string) $response->getBody(), true);

        $this->assertSame('Bearer', $token['token_type']);
        $this->assertArrayHasKey('id_token', $token);
        $this->assertArrayHasKey('expires_in', $token);
        $this->assertArrayHasKey('access_token', $token);
    }
}
