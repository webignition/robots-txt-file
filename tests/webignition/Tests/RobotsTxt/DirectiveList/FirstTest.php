<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

class FirstTest extends DirectiveListTest {
    
    public function testFirst() {      
        $this->directiveList->add('field1:value1');                
        $this->directiveList->add('field2:value2');
        $this->directiveList->add('field3:value3'); 
        
        $this->assertEquals('field1:value1', (string)$this->directiveList->first());
    }    
    
}