<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Hooks;

use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * LocaleItemsProcFunc
 */
final class LocaleItemsProcFunc
{
    public const CALLBACK = self::class . '->getItems';

    public function getItems(array &$configuration)
    {
        $locales = GeneralUtility::makeInstance(Locales::class);
        $languages = $locales->getLanguages();
        unset($languages['default']);
        $languages['en'] = 'English';
        asort($languages);
        foreach ($languages as $isoCode => $label) {
            $configuration['items'][] = [$label, $isoCode];
        }
    }
}
