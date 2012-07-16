<?php
ini_set('display_errors', 'On');

class DirectiveIsTest extends PHPUnit_Framework_TestCase {

    public function testIs() {
        $directive1 = new \webignition\RobotsTxt\Directive\Directive();
        $directive1->parse('field1:value1');

        $directive2 = new \webignition\RobotsTxt\Directive\Directive();
        $directive2->parse('field2:value2');
        
        $this->assertTrue($directive1->is('field1'));
        $this->assertTrue($directive2->is('field2'));
        
        $this->assertFalse($directive1->is('field2'));
        $this->assertFalse($directive2->is('field1'));
    }
   
}