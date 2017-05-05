<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\Directive;

class ParseFromStringTest extends DirectiveTest
{
    /**
     * @var Directive
     */
    private $directive;

    protected function setUp()
    {
        parent::setUp();
        $this->directive = new Directive();
    }

    public function testParseValidDirectiveFromString()
    {
        $this->directive->parse('allow:/allowed-path');

        $this->assertTrue($this->directive->isValid());
        $this->assertEquals('allow', (string)$this->directive->getField());
        $this->assertEquals('/allowed-path', (string)$this->directive->getValue());
    }
}
