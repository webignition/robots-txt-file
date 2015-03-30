<?php

namespace webignition\Tests\RobotsTxt\Directive\Value;

use webignition\RobotsTxt\Directive\Value;
use webignition\Tests\RobotsTxt\Directive\DirectiveTest;

class ValueTest extends DirectiveTest {

    public function testSetGetValidValues() {        
        $directiveValue = new Value();
        
        $directiveValue->set('value1');        
        $this->assertEquals('value1', $directiveValue->get());
        
        $directiveValue->set('value2');
        $this->assertEquals('value2', $directiveValue->get());        
    }
}