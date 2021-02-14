<?php

namespace R3H6\OidcServer\Controller;

use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Repositories\IdentityProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use R3H6\Oauth2Server\Security\ResourceGuardAwareInterface;
use R3H6\Oauth2Server\Security\ResourceGuardAwareTrait;
use TYPO3\CMS\Core\Http\JsonResponse;

class UserinfoController implements ResourceGuardAwareInterface
{
    use ResourceGuardAwareTrait;

    /**
     * @var \OpenIDConnectServer\Repositories\IdentityProviderInterface
     */
    protected $identityProvider;

    /**
     * @var \OpenIDConnectServer\ClaimExtractor
     */
    protected $claimExtractor;

    public function __construct(IdentityProviderInterface $identityProvider, ClaimExtractor $claimExtractor)
    {
        $this->identityProvider = $identityProvider;
        $this->claimExtractor = $claimExtractor;
    }

    public function getClaims(ServerRequestInterface $request): ResponseInterface
    {
        $this->resourceGuard->validateAuthenticatedRequest($request);

        $userEntity = $this->identityProvider->getUserEntityByIdentifier($request->getAttribute('oauth_user_id'));

        $scopes = $request->getAttribute('oauth_scopes');
        $claims = $this->claimExtractor->extract($scopes, $userEntity->getClaims());
        $claims['sub'] = $userEntity->getIdentifier();

        return new JsonResponse($claims);
    }
}
