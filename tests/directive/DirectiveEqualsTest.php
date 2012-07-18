<?php

class DirectiveEqualsTest extends PHPUnit_Framework_TestCase {

    public function testEquals() {
        $directive1 = new \webignition\RobotsTxt\Directive\Directive();
        $directive1->parse('field1:value1');

        $directive2 = new \webignition\RobotsTxt\Directive\Directive();
        $directive2->parse('field1:value1');
        
        $directive3 = new \webignition\RobotsTxt\Directive\Directive();
        $directive3->parse('field3:value3');      
        
        $this->assertTrue($directive1->equals($directive2));
        $this->assertFalse($directive1->equals($directive3));
    }
   
}