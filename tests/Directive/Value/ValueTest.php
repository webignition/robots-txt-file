<?php

namespace webignition\Tests\RobotsTxt\Directive\Value;

use webignition\RobotsTxt\Directive\Value;
use webignition\Tests\RobotsTxt\Directive\DirectiveTest;

class ValueTest extends DirectiveTest
{
    /**
     * @dataProvider directiveStringValueDataProvider
     */
    public function testSetGetValidValues($directiveStringValue)
    {
        $directiveValue = new Value();

        $directiveValue->set($directiveStringValue);
        $this->assertEquals($directiveStringValue, $directiveValue->get());
    }

    /**
     * @return array
     */
    public function directiveStringValueDataProvider()
    {
        return [
            ['value1'],
            ['value2'],
        ];
    }
}
