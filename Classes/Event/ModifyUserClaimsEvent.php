<?php

namespace R3H6\OidcServer\Event;

use R3H6\OidcServer\Domain\Model\User;

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
