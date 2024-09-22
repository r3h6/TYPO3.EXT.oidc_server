<?php

declare(strict_types=1);

namespace R3H6\OidcServer\EventListener;

use R3H6\Oauth2Server\Event\ModifyAuthenticationRedirectEvent;
use R3H6\OidcServer\Exception\LoginRequiredException;

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

final class HandlePromptParamForAuthentication
{
    public function __invoke(ModifyAuthenticationRedirectEvent $event): void
    {
        if ($event->getConfiguration()['oidc'] ?? false) {
            $prompt = $event->getContext()->getRequest()->getQueryParams()['prompt'] ?? null;
            if ($prompt === 'none' && $event->getRequiresAuthentication()) {
                throw new LoginRequiredException();
            }
        }
    }
}
