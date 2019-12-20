<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Directive;

use webignition\RobotsTxt\Directive\Value;

class ValueTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider directiveStringValueDataProvider
     */
    public function testSetGetValidValues(string $directiveStringValue, string $expectedStringValue)
    {
        $directiveValue = new Value($directiveStringValue);

        $this->assertEquals($expectedStringValue, (string) $directiveValue);
    }

    public function directiveStringValueDataProvider(): array
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
