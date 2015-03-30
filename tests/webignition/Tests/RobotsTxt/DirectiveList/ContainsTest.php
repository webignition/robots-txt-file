<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

class ContainsTest extends DirectiveListTest {

    public function testContains() {
        $this->directiveList->add('field1:value1');
        $this->directiveList->add('field2:value2');
        $this->directiveList->add('field3:value3');
        
        $this->assertTrue($this->directiveList->contains('field1:value1'));
        $this->assertTrue($this->directiveList->contains('fIeld2:value2'));
        $this->assertTrue($this->directiveList->contains('fiELd3:value3'));
        $this->assertFalse($this->directiveList->contains('doesnotcontain:value'));
    }
    
}