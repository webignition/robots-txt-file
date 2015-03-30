<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\Directive;

class ParseFromStringTest extends DirectiveTest {

    public function testParseVaildDirectiveFromString() { 
        $directive = new Directive();
        $directive->parse('allow:/allowed-path');
        
        $this->assertTrue($directive->isValid());
        $this->assertEquals('allow', (string)$directive->getField());
        $this->assertEquals('/allowed-path', (string)$directive->getValue());        
    }
    
    public function testParseInvaildDirectiveFromString() {
        $directive = new Directive();
        $directive->parse('no-field-value-separator');
        
        $this->assertFalse($directive->isValid());
    }

}