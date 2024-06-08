<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Domain\Model;

use League\OAuth2\Server\Entities\UserEntityInterface;
use OpenIDConnectServer\Entities\ClaimSetInterface;
use R3H6\Oauth2Server\Domain\Model\FrontendUser;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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

class User extends FrontendUser implements UserEntityInterface, ClaimSetInterface
{
    protected int $tstamp = 0;
    protected string $nickname = '';
    protected string $gender = '';
    protected ?\DateTime $birthdate = null;
    protected string $locale = '';
    protected string $zoneinfo = '';

    public function getIdentifier()
    {
        return $this->uid;
    }

    public function getClaims(): array
    {
        $claims = [
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
            'nickname' => $this->nickname,
            'preferred_username' => $this->username,
            'profile' => '',
            'picture' => call_user_func(function (ObjectStorage $images): string {
                foreach ($images as $image) {
                    return GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST') . '/' . $image->getOriginalResource()->getPublicUrl();
                }
                return '';
            }, $this->image),
            'website' => $this->www,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate ? $this->birthdate->format('Y-m-d') : null,
            'zoneinfo' => $this->zoneinfo,
            'locale' => $this->locale,
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
                trim($this->zip . ' ' . $this->city),
                trim($this->country),
            ])),
        ];

        $hooks = (array)($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['oidc_server']['domain/model/user/modify-claims'] ?? []);
        foreach ($hooks as $classRef) {
            if (is_a($classRef, UserGetClaimsHookInterface::class, true)) {
                $hook = GeneralUtility::makeInstance($classRef);
                $hook->modifyClaims($claims, $this);
            }
        }

        return $claims;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function getBirthdate(): ?\DateTime
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTime $birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}
