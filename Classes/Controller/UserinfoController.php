<?php

namespace R3H6\OidcServer\Controller;

use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Repositories\IdentityProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

class UserinfoController
{
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
        $userEntity = $this->identityProvider->getUserEntityByIdentifier($request->getAttribute('oauth_user_id'));

        $scopes = $request->getAttribute('oauth_scopes');
        $claims = $this->claimExtractor->extract($scopes, $userEntity->getClaims());
        $claims['sub'] = $userEntity->getIdentifier();

        return new JsonResponse($claims);
    }
}
