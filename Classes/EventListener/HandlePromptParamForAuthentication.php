<?php

namespace R3H6\OidcServer\EventListener;

use R3H6\Oauth2Server\Event\ModifyAuthenticationRedirectEvent;
use R3H6\OidcServer\Exception\LoginRequiredException;

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
