<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\Directive;
use webignition\Tests\RobotsTxt\BaseTest;

class DirectiveTest extends BaseTest
{
    /**
     * @dataProvider castToStringDataProvider
     *
     * @param string $field
     * @param string $value
     * @param string $expectedString
     */
    public function testCastToString($field, $value, $expectedString)
    {
        $directive = new Directive($field, $value);

        $this->assertEquals($expectedString, (string)$directive);
    }

    /**
     * @return array
     */
    public function castToStringDataProvider()
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
     *
     * @param string $field
     * @param string $expectedFieldType
     */
    public function testIsType($field, $expectedFieldType)
    {
        $directive = new Directive($field, 'foo');

        $this->assertTrue($directive->isType($expectedFieldType));
    }

    /**
     * @return array
     */
    public function isTypeDataProvider()
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
