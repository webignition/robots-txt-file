<?php

namespace webignition\Tests\RobotsTxt\Directive\CastToString;

use webignition\RobotsTxt\Directive\Directive;
use webignition\Tests\RobotsTxt\Directive\DirectiveTest;

class CastToStringTest extends DirectiveTest
{
    public function testCastingToString()
    {
        $directive = new Directive();
        $directive->parse('allow:/allowed-path');

        $this->assertEquals('allow:/allowed-path', (string)$directive);
    }
}
