<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\Directive;

class DirectiveIsTest extends DirectiveTest
{
    public function testIs()
    {
        $directive1 = new Directive();
        $directive1->parse('field1:value1');

        $directive2 = new Directive();
        $directive2->parse('field2:value2');

        $this->assertTrue($directive1->is('field1'));
        $this->assertTrue($directive2->is('field2'));

        $this->assertFalse($directive1->is('field2'));
        $this->assertFalse($directive2->is('field1'));
    }
}
