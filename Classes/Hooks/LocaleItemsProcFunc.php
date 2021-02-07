<?php
namespace R3H6\OidcServer\Hooks;

use TYPO3\CMS\Core\Localization\Locales;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LocaleItemsProcFunc
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
