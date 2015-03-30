<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

class AddTest extends DirectiveListTest {
    
    public function testAdd() {
        $this->directiveList->add('allow:/allowed-path');
        $this->assertEquals(array('allow:/allowed-path'), $this->directiveList->getValues());

        $this->directiveList->add('disallow:/disallowed-path');
        $this->assertEquals(array('allow:/allowed-path', 'disallow:/disallowed-path'), $this->directiveList->getValues());
    }
}