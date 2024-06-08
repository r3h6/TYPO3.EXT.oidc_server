<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Tests\Unit\Domain\Model;

use R3H6\OidcServer\Domain\Model\User;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

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
 * UserTest
 */
class UserTest extends UnitTestCase
{
    /**
     * @var User
     */
    protected $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new User();
    }

    /**
     * @test
     */
    public function getClaimsContainsPicture(): void
    {
        // $GLOBALS['_SERVER']['REQUEST_URI'] = 'http://localhost/oauth/userinfo';
        GeneralUtility::setIndpEnv('TYPO3_REQUEST_HOST', 'http://localhost');

        $resource = $this->prophesize(FileInterface::class);
        $resource->getPublicUrl()->willReturn('fileadmin/user_upload/profile.jpg');
        $image = $this->prophesize(FileReference::class);
        $image->getOriginalResource()->willReturn($resource->reveal());
        $images = new ObjectStorage();
        $images->attach($image->reveal());
        $this->subject->setImage($images);

        $claims = $this->subject->getClaims();
        self::assertIsArray($claims);
        self::assertSame('http://localhost/fileadmin/user_upload/profile.jpg', $claims['picture']);
    }
}
