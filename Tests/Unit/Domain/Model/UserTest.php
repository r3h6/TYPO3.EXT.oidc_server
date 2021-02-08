<?php
namespace R3H6\OidcServer\Tests\Unit\Domain\Model;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;

/**
 * Test case.
 */
class UserTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;

    /**
     * @var \R3H6\OidcServer\Domain\Model\User
     */
    protected $subject = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new \R3H6\OidcServer\Domain\Model\User();
    }

    /**
     * @test
     */
    public function getClaimsContainsPicture()
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

    /**
     * @test
     */
    public function getClaimsContainsRoles()
    {
        $groups = new ObjectStorage();

        $group1 = $this->prophesize(FrontendUserGroup::class);
        $group1->getTitle()->willReturn('Group 1');
        $groups->attach($group1->reveal());

        $group2 = $this->prophesize(FrontendUserGroup::class);
        $group2->getTitle()->willReturn('Group 2');
        $groups->attach($group2->reveal());

        $this->subject->setUsergroup($groups);

        $claims = $this->subject->getClaims();
        self::assertIsArray($claims);
        self::assertSame('Group 1, Group 2', $claims['Roles']);
    }
}
