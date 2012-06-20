<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class DirectiveEqualsTest extends PHPUnit_Framework_TestCase {

    public function testEquals() {
        $directive1 = new \webignition\RobotsTxt\Directive\Directive();
        $directive1->setField('field1');
        $directive1->setValue('value1');

        $directive2 = new \webignition\RobotsTxt\Directive\Directive();
        $directive2->setField('field1');
        $directive2->setValue('value1');
        
        $directive3 = new \webignition\RobotsTxt\Directive\Directive();
        $directive3->setField('field3');
        $directive3->setValue('value3');        
        
        $this->assertTrue($directive1->equals($directive2));
        $this->assertFalse($directive1->equals($directive3));
    }
   
}