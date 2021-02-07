<?php
namespace R3H6\OidcServer\Domain\Model;

use TYPO3\CMS\Core\Http\Uri;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
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
     * tstamp
     *
     * @var int
     */
    protected $tstamp = null;

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
    protected $birthdate = null;

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
            'nickname' => $this->nickname,
            'preferred_username' => $this->username,
            'profile' => '',
            'picture' => call_user_func(function(ObjectStorage $images){
                    foreach ($images as $image) {
                        /** @var Uri $requestUri */
                        $requestUri = GeneralUtility::makeInstance(Uri::class, $_SERVER['REQUEST_URI']);
                        return $requestUri->getScheme() . '://' . $requestUri->getHost() . '/' . $image->getOriginalResource()->getPublicUrl();
                    }
                    return '';
                }, $this->image),
            'website' => $this->www,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate ? $this->birthdate->format('Y-m-d') : '0000',
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
                trim($this->zip .' '. $this->city),
                trim($this->country),
            ])),

            // Custom
            'Roles' => implode(', ', array_map(function(FrontendUserGroup $group) {
                    return $group->getTitle();
                }, $this->usergroup->toArray())),
        ];
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}
