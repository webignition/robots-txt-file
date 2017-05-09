<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\Value;
use webignition\Tests\RobotsTxt\BaseTest;

class ValueTest extends BaseTest
{
    /**
     * @dataProvider directiveStringValueDataProvider
     *
     * @param string $directiveStringValue
     * @param string $expectedStringValue
     */
    public function testSetGetValidValues($directiveStringValue, $expectedStringValue)
    {
        $directiveValue = new Value($directiveStringValue);

        $this->assertEquals((string)$directiveValue, $expectedStringValue);
    }

    /**
     * @return array
     */
    public function directiveStringValueDataProvider()
    {
        return [
            'generic value 1' => [
                'directiveStringValue' => 'value1',
                'expectedStringValue' => 'value1',
            ],
            'generic value 2' => [
                'directiveStringValue' => 'value2',
                'expectedStringValue' => 'value2',
            ],
            'with line return' => [
                'directiveStringValue' => 'foo' . "\n" . 'bar',
                'expectedStringValue' => 'foo',
            ],
            'with carriage return' => [
                'directiveStringValue' => 'foo' . "\r" . 'bar',
                'expectedStringValue' => 'foo',
            ],
            'with comment' => [
                'directiveStringValue' => 'foo #bar',
                'expectedStringValue' => 'foo',
            ],
        ];
    }
}
