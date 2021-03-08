<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Controller;

use R3H6\Oauth2Server\Mvc\Controller\AuthorizationContext;
use R3H6\OidcServer\Exception\ConsentRequiredException;
use R3H6\OidcServer\Exception\LoginRequiredException;

/***
 *
 * This file is part of the "OAuth2 Server" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020
 *
 ***/

 /**
  * Authorization endpoint
  */
class AuthorizationController extends \R3H6\Oauth2Server\Controller\AuthorizationController
{
    /**
     * @override
     */
    protected function requiresAuthentication(AuthorizationContext $context): bool
    {
        $requiresAuthentication = parent::requiresAuthentication($context);
        $prompt = $context->getRequest()->getQueryParams()['prompt'] ?? null;

        if ($prompt === 'none' && $requiresAuthentication) {
            throw new LoginRequiredException();
        }

        return $requiresAuthentication;
    }

    /**
     * @override
     */
    protected function requiresConsent(AuthorizationContext $context): bool
    {
        $requiresConsent = parent::requiresConsent($context);
        $prompt = $context->getRequest()->getQueryParams()['prompt'] ?? null;

        if ($prompt === 'none' && $requiresConsent) {
            throw new ConsentRequiredException();
        }

        return $requiresConsent;
    }
}
