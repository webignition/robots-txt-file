<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\DirectiveList;

use webignition\RobotsTxt\Directive\UserAgentDirective;
use webignition\RobotsTxt\DirectiveList\UserAgentDirectiveList;

class UserAgentDirectiveListTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var UserAgentDirectiveList
     */
    private $userAgentDirectiveList;

    protected function setUp(): void
    {
        $this->userAgentDirectiveList = new UserAgentDirectiveList();
    }

    public function testAdd()
    {
        $this->userAgentDirectiveList->add(new UserAgentDirective('googlebot'));
        $this->assertEquals(array('googlebot'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->add(new UserAgentDirective('slURp'));
        $this->assertEquals(array('googlebot', 'slurp'), $this->userAgentDirectiveList->getValues());
    }

    public function testContains()
    {
        $userAgentDirective1 = new UserAgentDirective('agent1');
        $userAgentDirective2 = new UserAgentDirective('agent2');
        $userAgentDirective3 = new UserAgentDirective('agent3');

        $this->userAgentDirectiveList->add($userAgentDirective1);
        $this->userAgentDirectiveList->add($userAgentDirective2);
        $this->userAgentDirectiveList->add($userAgentDirective3);

        $this->assertTrue($this->userAgentDirectiveList->contains($userAgentDirective1));
        $this->assertTrue($this->userAgentDirectiveList->contains($userAgentDirective2));
        $this->assertTrue($this->userAgentDirectiveList->contains($userAgentDirective3));
    }

    public function testRemove()
    {
        $userAgentDirective1 = new UserAgentDirective('agent1');
        $userAgentDirective2 = new UserAgentDirective('agent2');
        $userAgentDirective3 = new UserAgentDirective('agent3');

        $this->userAgentDirectiveList->add($userAgentDirective1);
        $this->userAgentDirectiveList->add($userAgentDirective2);
        $this->userAgentDirectiveList->add($userAgentDirective3);

        $this->assertEquals(array('agent1', 'agent2', 'agent3'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->remove($userAgentDirective1);
        $this->assertEquals(array('agent2', 'agent3'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->remove($userAgentDirective2);
        $this->assertEquals(array('agent3'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->remove($userAgentDirective3);
        $this->assertEquals(array('*'), $this->userAgentDirectiveList->getValues());
    }
}
