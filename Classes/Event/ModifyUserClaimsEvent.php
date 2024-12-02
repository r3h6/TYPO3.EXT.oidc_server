<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Event;

use R3H6\OidcServer\Domain\Model\User;

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

final class ModifyUserClaimsEvent
{
    public function __construct(
        private array $claims,
        private readonly User $user,
    ) {}

    public function getClaims(): array
    {
        return $this->claims;
    }

    public function setClaims(array $claims): void
    {
        $this->claims = $claims;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
