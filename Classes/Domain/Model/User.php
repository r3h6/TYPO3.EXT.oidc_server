<?php
namespace R3H6\OidcServer\Domain\Model;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;
use OpenIDConnectServer\Entities\ClaimSetInterface;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

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
 * User
 */
final class User extends FrontendUser implements UserEntityInterface, ClaimSetInterface
{
    use EntityTrait;

    public function getClaims()
    {
        return [
            // profile
            'name' => $this->firstName . ' ' . $this->lastName,
            'family_name' => $this->lastName,
            'given_name' => $this->firstName,
            'middle_name' => $this->middleName,
            // 'nickname' => '',
            'preferred_username' => $this->username,
            'profile' => '',
            'picture' => 'avatar.png',
            'website' => $this->www,
            'gender' => 'M',
            'birthdate' => null,//$this->birthdate,Y-m-d
            'zoneinfo' => '',
            'locale' => 'US',
            'updated_at' => '01/01/2018',
            // email
            'email' => $this->email,
            'email_verified' => true,
            // phone
            'phone_number' => $this->telephone,
            'phone_number_verified' => true,
            // address
            'address' => '50 any street, any state, 55555',
        ];
    }
}
