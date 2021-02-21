<?php

namespace R3H6\OidcServer\Tests\Unit\Domain\Model;

use Psr\Log\LoggerInterface;
use R3H6\OidcServer\Domain\Model\User;
use R3H6\OidcServer\Hooks\RoleClaimHook;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case.
 */
class RoleClaimHookTest extends \TYPO3\TestingFramework\Core\Unit\UnitTestCase
{
    use \Prophecy\PhpUnit\ProphecyTrait;

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

        $user = $this->prophesize(User::class);
        $user->getUsergroup()->willReturn($groups);

        $claims = [];

        $subject = new RoleClaimHook();
        $subject->setLogger($this->createStub(LoggerInterface::class));
        $subject->modifyClaims($claims, $user->reveal());

        self::assertSame('Group 1, Group 2', $claims['Roles']);
    }
}
