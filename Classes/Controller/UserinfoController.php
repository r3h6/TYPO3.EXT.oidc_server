<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Controller;

use OpenIDConnectServer\ClaimExtractor;
use OpenIDConnectServer\Repositories\IdentityProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

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
 * User
 */
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
