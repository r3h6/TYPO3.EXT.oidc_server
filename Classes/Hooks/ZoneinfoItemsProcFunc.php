<?php

namespace R3H6\OidcServer\Hooks;

final class ZoneinfoItemsProcFunc
{
    public const CALLBACK = self::class . '->getItems';

    public function getItems(array &$configuration)
    {
        foreach (\DateTimeZone::listIdentifiers() as $label) {
            $configuration['items'][] = [$label, $label];
        }
    }
}
