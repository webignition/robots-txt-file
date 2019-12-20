<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Directive;

use webignition\RobotsTxt\Directive\Directive;

class DirectiveTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider castToStringDataProvider
     */
    public function testCastToString(string $field, string $value, string $expectedString)
    {
        $directive = new Directive($field, $value);

        $this->assertEquals($expectedString, (string)$directive);
    }

    public function castToStringDataProvider(): array
    {
        return [
            [
                'field' => 'allow',
                'value' => '/path-1',
                'expectedString' => 'allow:/path-1',
            ],
            [
                'field' => 'disallow',
                'value' => '/path-2',
                'expectedString' => 'disallow:/path-2',
            ],
        ];
    }

    public function testEquals()
    {
        $directive1 = new Directive('field1', 'value1');
        $directive2 = new Directive('field1', 'value1');
        $directive3 = new Directive('field3', 'value3');

        $this->assertTrue($directive1->equals($directive2));
        $this->assertFalse($directive1->equals($directive3));
    }

    /**
     * @dataProvider isTypeDataProvider
     */
    public function testIsType(string $field, string $expectedFieldType)
    {
        $directive = new Directive($field, 'foo');

        $this->assertTrue($directive->isType($expectedFieldType));
    }

    public function isTypeDataProvider(): array
    {
        return [
            'generic field 1' => [
                'field' => 'field1',
                'expectedType' => 'field1',
            ],
            'generic field 2' => [
                'field' => 'field2',
                'expectedType' => 'field2',
            ],
            'sitemap' => [
                'field' => Directive::TYPE_SITEMAP,
                'expectedType' => Directive::TYPE_SITEMAP,
            ],
        ];
    }
}
