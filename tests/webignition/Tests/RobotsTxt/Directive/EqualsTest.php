<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\Directive;

class EqualsTest extends DirectiveTest {

    public function testEquals() {
        $directive1 = new Directive();
        $directive1->parse('field1:value1');

        $directive2 = new Directive();
        $directive2->parse('field1:value1');
        
        $directive3 = new Directive();
        $directive3->parse('field3:value3');      
        
        $this->assertTrue($directive1->equals($directive2));
        $this->assertFalse($directive1->equals($directive3));
    }
   
}