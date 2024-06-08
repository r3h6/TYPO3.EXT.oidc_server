<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Domain\Model;

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

interface UserGetClaimsHookInterface
{
    public function modifyClaims(array &$claims, User $user): void;
}
