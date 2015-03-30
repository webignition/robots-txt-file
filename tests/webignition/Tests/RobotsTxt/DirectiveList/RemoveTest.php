<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

class RemoveTest extends DirectiveListTest {

    public function testRemove() {
        $this->directiveList->add('field1:value1');
        $this->directiveList->add('field2:value2');
        $this->directiveList->add('field3:value3');
        $this->assertEquals(array('field1:value1', 'field2:value2', 'field3:value3'), $this->directiveList->getValues());

        $this->directiveList->remove('fieLD1:value1');
        $this->assertEquals(array('field2:value2', 'field3:value3'), $this->directiveList->getValues());

        $this->directiveList->remove('field2:value2');
        $this->assertEquals(array('field3:value3'), $this->directiveList->getValues());

        $this->directiveList->remove('fielD3:value3');
        $this->assertEquals(array(), $this->directiveList->getValues());
    }
    
}