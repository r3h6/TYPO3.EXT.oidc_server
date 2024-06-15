<?php

use R3H6\OidcServer\Hooks\LocaleItemsProcFunc;
use R3H6\OidcServer\Hooks\ZoneinfoItemsProcFunc;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die();

$GLOBALS['TCA']['fe_users']['types']['Tx_OidcServer_User'] = $GLOBALS['TCA']['fe_users']['types']['0'];
$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = [
    'label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_OidcServer_User',
    'value' => 'Tx_OidcServer_User',
];

$tmp_oidc_server_columns = [

    'tstamp' => [
        'config' => [
            'type' => 'passthrough',
        ],
    ],
    'tx_oidcserver_nickname' => [
        'exclude' => true,
        'label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_oidcserver_nickname',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim',
        ],
    ],
    'tx_oidcserver_gender' => [
        'exclude' => true,
        'label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_oidcserver_gender',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_oidcserver_gender.male', 'value' => 'male'],
                ['label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_oidcserver_gender.female', 'value' => 'female'],
            ],
        ],
    ],
    'tx_oidcserver_birthdate' => [
        'exclude' => true,
        'label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_oidcserver_birthdate',
        'config' => [
            'dbType' => 'date',
            'type' => 'datetime',
            'size' => 7,
            'default' => null,
            'format' => 'date',
        ],
    ],
    'tx_oidcserver_locale' => [
        'exclude' => true,
        'label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_oidcserver_locale',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => '', 'value' => ''],
            ],
            'itemsProcFunc' => LocaleItemsProcFunc::CALLBACK,
        ],
    ],
    'tx_oidcserver_zoneinfo' => [
        'exclude' => true,
        'label' => 'LLL:EXT:oidc_server/Resources/Private/Language/locallang_db.xlf:fe_users.tx_oidcserver_zoneinfo',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['label' => '', 'value' => ''],
            ],
            'itemsProcFunc' => ZoneinfoItemsProcFunc::CALLBACK,
        ],
    ],

];

ExtensionManagementUtility::addTCAcolumns('fe_users', $tmp_oidc_server_columns);
ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_oidcserver_nickname', 'Tx_OidcServer_User', 'after:name');
ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_oidcserver_gender', 'Tx_OidcServer_User', 'before:name');
ExtensionManagementUtility::addToAllTCAtypes('fe_users', 'tx_oidcserver_birthdate, tx_oidcserver_locale, tx_oidcserver_zoneinfo', 'Tx_OidcServer_User', 'after:image');
