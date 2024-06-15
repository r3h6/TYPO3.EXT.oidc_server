<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Tests\Unit\Controller;

use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Repositories\IdentityProviderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use R3H6\OidcServer\Controller\UserinfoController;
use R3H6\OidcServer\Domain\Model\User;
use TYPO3\CMS\Core\Http\JsonResponse;

class UserinfoControllerTest extends TestCase
{
    private MockObject&IdentityProviderInterface $identityProviderMock;
    private MockObject&ClaimExtractor $claimExtractorMock;
    private MockObject&ServerRequestInterface $requestMock;
    private MockObject&User $userEntityMock;
    private UserinfoController $userinfoController;

    protected function setUp(): void
    {
        $this->identityProviderMock = $this->createMock(IdentityProviderInterface::class);
        $this->claimExtractorMock = $this->createMock(ClaimExtractor::class);
        $this->requestMock = $this->createMock(ServerRequestInterface::class);
        $this->userEntityMock = $this->createMock(User::class);

        $this->userinfoController = new UserinfoController(
            $this->identityProviderMock,
            $this->claimExtractorMock
        );
    }

    public function testGetClaimsReturnsJsonResponseWithClaims(): void
    {
        $oauthUserId = 'test_user_id';
        $scopes = ['openid', 'profile'];
        $claims = ['sub' => $oauthUserId, 'name' => 'Test User', 'email' => '', 'email_verified' => false];
        $expectedClaims = ['sub' => $oauthUserId, 'name' => 'Test User', 'email_verified' => false];

        $this->requestMock->method('getAttribute')
            ->willReturnMap([
                ['oauth_user_id', null, $oauthUserId],
                ['oauth_scopes', null, $scopes],
            ]);

        $this->identityProviderMock->expects(self::once())
            ->method('getUserEntityByIdentifier')
            ->with($oauthUserId)
            ->willReturn($this->userEntityMock);

        $this->userEntityMock->method('getIdentifier')->willReturn($oauthUserId);
        $this->userEntityMock->method('getClaims')->willReturn([]);

        $this->claimExtractorMock->expects(self::once())
            ->method('extract')
            ->with($scopes, [])
            ->willReturn($claims);

        $response = $this->userinfoController->getClaims($this->requestMock);

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(json_encode($expectedClaims), (string)$response->getBody());
    }

    public function testGetClaimsThrowsRuntimeExceptionWhenUserNotFound(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('User not found');

        $this->requestMock->method('getAttribute')->with('oauth_user_id')->willReturn('nonexistent_user_id');
        $this->identityProviderMock->method('getUserEntityByIdentifier')->willReturn(null);

        $this->userinfoController->getClaims($this->requestMock);
    }
}
