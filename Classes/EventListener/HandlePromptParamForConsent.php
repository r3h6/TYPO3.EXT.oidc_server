<?php

namespace R3H6\OidcServer\EventListener;

use R3H6\Oauth2Server\Event\ModifyConsentRedirectEvent;
use R3H6\OidcServer\Exception\ConsentRequiredException;

final class HandlePromptParamForConsent
{
    public function __invoke(ModifyConsentRedirectEvent $event): void
    {
        if ($event->getConfiguration()['oidc'] ?? false) {
            $prompt = $event->getContext()->getRequest()->getQueryParams()['prompt'] ?? null;
            if ($prompt === 'none' && $event->getRequiresConsent()) {
                throw new ConsentRequiredException();
            }
        }
    }
}
