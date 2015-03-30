<?php

namespace webignition\Tests\RobotsTxt\UserAgentDirectiveList;

class RemoveTest extends UserAgentDirectiveListTest {

    public function testRemove() {
        $this->userAgentDirectiveList->add('agent1');
        $this->userAgentDirectiveList->add('agent2');
        $this->userAgentDirectiveList->add('agent3');

        $this->assertEquals(array('agent1', 'agent2', 'agent3'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->remove('aGEnt1');
        $this->assertEquals(array('agent2', 'agent3'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->remove('agent2');
        $this->assertEquals(array('agent3'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->remove('agent3');
        $this->assertEquals(array('*'), $this->userAgentDirectiveList->getValues());
    }
    
}