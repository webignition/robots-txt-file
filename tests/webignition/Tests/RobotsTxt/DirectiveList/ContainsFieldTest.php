<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

class ContainsFieldTest extends DirectiveListTest {

    public function testContainsField() {
        $this->directiveList->add('field1:value1');                
        $this->directiveList->add('field2:value2');
        $this->directiveList->add('field3:value3'); 
        
        $this->assertTrue($this->directiveList->containsField('field1'));        
        $this->assertFalse($this->directiveList->containsField('field4'));
    }
    
}