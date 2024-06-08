<?php

declare(strict_types=1);

namespace R3H6\OidcServer\Tests\Unit\Domain\Model;

use Psr\Log\LoggerInterface;
use R3H6\OidcServer\Domain\Model\User;
use R3H6\OidcServer\Hooks\RoleClaimHook;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup;
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
 * RoleClaimHookTest
 */
class RoleClaimHookTest extends UnitTestCase
{
    /**
     * @test
     */
    public function getClaimsContainsRoles(): void
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
