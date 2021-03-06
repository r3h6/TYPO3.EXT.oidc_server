<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Exception;

use League\OAuth2\Server\Exception\OAuthServerException;

class LoginRequiredException extends OAuthServerException
{
    public function __construct(string $hint = null)
    {
        parent::__construct('The client specified not to prompt, but the user is not logged in.', 1614367019419, 'login_required', 400, $hint);
    }
}
