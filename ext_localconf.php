<?php

defined('TYPO3') || die('Access denied.');

call_user_func(
    function (): void {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['oidc_server']['domain/model/user/modify-claims']['Roles'] = \R3H6\OidcServer\Hooks\RoleClaimHook::class;
    }
);
