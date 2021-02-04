<?php

namespace R3H6\OidcServer\Controller;

use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\JsonResponse;
use OpenIDConnectServer\ClaimExtractor;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ServerRequestInterface;
use OpenIDConnectServer\Repositories\IdentityProviderInterface;

class UserinfoController
{
    /**
     * @var \OpenIDConnectServer\Repositories\IdentityProviderInterface
     */
    protected $identityProvider;

    /**
     * @var \League\OAuth2\Server\ResourceServer
     */
    protected $server;

    /**
     * @var \OpenIDConnectServer\ClaimExtractor
     */
    protected $claimExtractor;

    public function __construct(ResourceServer $server, IdentityProviderInterface $identityProvider, ClaimExtractor $claimExtractor)
    {
        $this->identityProvider = $identityProvider;
        $this->server = $server;
        $this->claimExtractor = $claimExtractor;
    }

    public function getClaims(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getUri()->getScheme() !== 'https') {
            return new Response('Must use https', 403);
        }

        $request = $this->server->validateAuthenticatedRequest($request);

        // $https = $request->getServerParams()['HTTPS'] ?? 'off';
        // if ('on' !== $https) {
        //     return new Response('', 500);
        // }

        $userEntity = $this->identityProvider->getUserEntityByIdentifier($request->getAttribute('oauth_user_id'));

        $scopes = $request->getAttribute('oauth_scopes');
        $claims = $this->claimExtractor->extract($scopes, $userEntity->getClaims());
        $claims['sub'] = $userEntity->getIdentifier();



        return new JsonResponse($claims);
    }
}
