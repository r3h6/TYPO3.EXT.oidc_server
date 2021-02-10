<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['oidc_server']['domain/model/user/modify-claims']['Roles'] = \R3H6\OidcServer\Hooks\RoleClaimHook::class;

    }
);
