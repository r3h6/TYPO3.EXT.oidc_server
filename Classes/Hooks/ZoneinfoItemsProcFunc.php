<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Hooks;

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
 * ZoneinfoItemsProcFunc
 */
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
