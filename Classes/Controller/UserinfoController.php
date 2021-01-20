<?php

namespace R3H6\OidcServer\Controller;

use OpenIDConnectServer\ClaimExtractor;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Server\ResourceServer;
use Psr\Http\Message\ServerRequestInterface;
use R3H6\OidcServer\Domain\Repository\UserRepository;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Http\Response;

class UserinfoController
{
    /**
     * @var \R3H6\OidcServer\Domain\Repository\UserRepository
     */
    protected $userRepository;

    /**
     * @var \League\OAuth2\Server\ResourceServer
     */
    protected $server;

    /**
     * @var \OpenIDConnectServer\ClaimExtractor
     */
    protected $claimExtractor;

    public function __construct(ResourceServer $server, UserRepository $userRepository, ClaimExtractor $claimExtractor)
    {
        $this->userRepository = $userRepository;
        $this->server = $server;
        $this->claimExtractor = $claimExtractor;
    }

    public function getAction(ServerRequestInterface $request): ResponseInterface
    {
        $request = $this->server->validateAuthenticatedRequest($request);

        // $https = $request->getServerParams()['HTTPS'] ?? 'off';
        // if ('on' !== $https) {
        //     return new Response('', 500);
        // }

        $userEntity = $this->userRepository->getUserEntityByIdentifier($request->getAttribute('oauth_user_id'));

        $scopes = $request->getAttribute('oauth_scopes');
        $claims = $this->claimExtractor->extract($scopes, $userEntity->getClaims());
        $claims['sub'] = $userEntity->getIdentifier();



        return new JsonResponse($claims);
    }
}
