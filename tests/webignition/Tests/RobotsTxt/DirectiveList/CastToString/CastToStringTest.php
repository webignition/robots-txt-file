<?php

namespace webignition\Tests\RobotsTxt\DirectiveList\CastToString;

use webignition\RobotsTxt\DirectiveList\DirectiveList;
use webignition\Tests\RobotsTxt\Directive\DirectiveTest;

class CastToStringTest extends DirectiveTest
{
    public function testCastingListToString()
    {
        $list = new DirectiveList();

        $list->add('field1:value1');
        $this->assertEquals('field1:value1', (string)$list);

        $list->add('field2:value2');
        $this->assertEquals('field1:value1'."\n".'field2:value2', (string)$list);
    }
}
