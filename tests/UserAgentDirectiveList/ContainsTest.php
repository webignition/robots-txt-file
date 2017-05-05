<?php

namespace webignition\Tests\RobotsTxt\UserAgentDirectiveList;

class ContainsTest extends UserAgentDirectiveListTest
{
    public function testContains()
    {
        $this->userAgentDirectiveList->add('agent1');
        $this->userAgentDirectiveList->add('agent2');
        $this->userAgentDirectiveList->add('AGent3');

        $this->assertTrue($this->userAgentDirectiveList->contains('agent1'));
        $this->assertTrue($this->userAgentDirectiveList->contains('agent2'));
        $this->assertTrue($this->userAgentDirectiveList->contains('agent3'));
        $this->assertFalse($this->userAgentDirectiveList->contains('doesnotcontain'));
    }
}
