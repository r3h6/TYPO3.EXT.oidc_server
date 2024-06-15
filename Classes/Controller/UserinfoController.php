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

class UserinfoController
{
    public function __construct(
        private readonly IdentityProviderInterface $identityProvider,
        private readonly ClaimExtractor $claimExtractor
    ) {}

    public function getClaims(ServerRequestInterface $request): ResponseInterface
    {
        $userEntity = $this->identityProvider->getUserEntityByIdentifier($request->getAttribute('oauth_user_id'));
        if ($userEntity === null) {
            throw new \RuntimeException('User not found', 1717704496933);
        }

        $scopes = (array) $request->getAttribute('oauth_scopes');
        $claims = $this->claimExtractor->extract($scopes, $userEntity->getClaims());
        $claims['sub'] = $userEntity->getIdentifier();

        $claims = array_filter($claims, static fn($value): bool => $value !== null && $value !== '');

        return new JsonResponse($claims);
    }
}
