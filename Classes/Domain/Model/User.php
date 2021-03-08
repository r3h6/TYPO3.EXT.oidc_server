<?php

declare(strict_types=1);
namespace R3H6\OidcServer\Domain\Model;

use League\OAuth2\Server\Entities\UserEntityInterface;
use OpenIDConnectServer\Entities\ClaimSetInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
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

/**
 * User
 */
class User extends FrontendUser implements UserEntityInterface, ClaimSetInterface
{
    /**
     * tstamp
     *
     * @var int
     */
    protected $tstamp;

    /**
     * nickname
     *
     * @var string
     */
    protected $nickname = '';

    /**
     * gender
     *
     * @var string
     */
    protected $gender = '';

    /**
     * birthdate
     *
     * @var \DateTime
     */
    protected $birthdate;

    /**
     * locale
     *
     * @var string
     */
    protected $locale = '';

    /**
     * zoneinfo
     *
     * @var string
     */
    protected $zoneinfo = '';

    public function getIdentifier()
    {
        return $this->uid;
    }

    public function getClaims()
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
            'picture' => call_user_func(function (ObjectStorage $images) {
                foreach ($images as $image) {
                    return GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST') . '/' . $image->getOriginalResource()->getPublicUrl(); // @phpstan-ignore-line
                }
                return '';
            }, $this->image),
            'website' => $this->www,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate ? $this->birthdate->format('Y-m-d') : '0000', // @phpstan-ignore-line
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

    /**
     * Returns the nickname
     *
     * @return string $nickname
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Sets the nickname
     *
     * @param string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * Returns the gender
     *
     * @return string $gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets the gender
     *
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * Returns the birthdate
     *
     * @return \DateTime $birthdate
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Sets the birthdate
     *
     * @param \DateTime $birthdate
     */
    public function setBirthdate(\DateTime $birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * Returns the locale
     *
     * @return string $locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Sets the locale
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
