<?php

namespace webignition\Tests\RobotsTxt\UserAgentDirectiveList;

class AddTest extends UserAgentDirectiveListTest {
    
    public function testAdd() {
        $this->userAgentDirectiveList->add('googlebot');
        $this->assertEquals(array('googlebot'), $this->userAgentDirectiveList->getValues());

        $this->userAgentDirectiveList->add('slURp');
        $this->assertEquals(array('googlebot', 'slurp'), $this->userAgentDirectiveList->getValues());
    }
    
}