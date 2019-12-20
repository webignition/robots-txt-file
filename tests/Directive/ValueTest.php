<?php

namespace webignition\RobotsTxt\Tests\Directive;

use webignition\RobotsTxt\Directive\Value;

class ValueTest extends \PHPUnit\Framework\TestCase
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

        $this->assertEquals($expectedStringValue, (string) $directiveValue);
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
