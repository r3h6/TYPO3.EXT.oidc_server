<?php
namespace R3H6\OidcServer\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use OpenIDConnectServer\Entities\ClaimSetInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
use League\OAuth2\Server\Entities\UserEntityInterface;

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
    /**
     * @var int
     */
    protected $tstamp;

    public function getIdentifier()
    {
        return $this->uid;
    }

    public function getClaims()
    {
        return [
            // profile
            'name' => implode(' ', array_filter([
                $this->title,
                $this->firstName,
                $this->middleName,
                $this->lastName,
            ])),
            'family_name' => $this->lastName,
            'given_name' => $this->firstName,
            'middle_name' => $this->middleName,
            'nickname' => '',
            'preferred_username' => $this->username,
            'profile' => '',
            'picture' => '',
            'website' => $this->www,
            'gender' => '',
            'birthdate' => '',
            'zoneinfo' => '',
            'locale' => '',
            'updated_at' => $this->tstamp,
            // email
            'email' => $this->email,
            'email_verified' => true,
            // phone
            'phone_number' => $this->telephone,
            'phone_number_verified' => true,
            // address
            'address' => implode(', ', array_filter([
                trim($this->address),
                trim($this->zip .' '. $this->city),
                trim($this->country),
            ])),

            // Custom
            'Roles' => implode(', ', array_map(function(FrontendUserGroup $group) {
                    return $group->getTitle();
                }, $this->usergroup->toArray())),
        ];
    }


}
