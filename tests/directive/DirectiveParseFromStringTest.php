<?php

class DirectiveParseFromStringTest extends PHPUnit_Framework_TestCase
{
    public function testParseVaildDirectiveFromString()
    {
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->parse('allow:/allowed-path');

        $this->assertTrue($directive->isValid());
        $this->assertEquals('allow', (string) $directive->getField());
        $this->assertEquals('/allowed-path', (string) $directive->getValue());
    }

    public function testParseInvaildDirectiveFromString()
    {
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->parse('no-field-value-separator');

        $this->assertFalse($directive->isValid());
    }

}
