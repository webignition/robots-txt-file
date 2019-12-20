<?php

namespace webignition\RobotsTxt\Tests\Directive;

use webignition\RobotsTxt\Directive\Factory;
use webignition\RobotsTxt\Directive\UserAgentDirective;

class FactoryTest extends \PHPUnit\Framework\TestCase
{
    const FIELD_USER_AGENT_DIRECTIVE = 'user-agent';
    const FIELD_DISALLOW_DIRECTIVE = 'disallow';

    /**
     * @dataProvider invalidDirectiveStringDataProvider
     *
     * @param string $directiveString
     */
    public function testCreateFromInvalidDirectiveString($directiveString)
    {
        $this->assertNull(Factory::create($directiveString));
    }

    /**
     * @return array
     */
    public function invalidDirectiveStringDataProvider()
    {
        return [
            'empty' => [
                'directiveString' => '',
            ],
            'no field:value separator' => [
                'directiveString' => 'foo',
            ],
            'starts with field:value separator' => [
                'directiveString' => ':foo',
            ],
        ];
    }

    /**
     * @dataProvider userAgentDirectiveDataProvider
     *
     * @param string $directiveString
     * @param string $expectedValue
     */
    public function testCreateUserAgentDirective($directiveString, $expectedValue)
    {
        $directive = Factory::create($directiveString);
        $this->assertInstanceOf(UserAgentDirective::class, $directive);

        $this->assertEquals(self::FIELD_USER_AGENT_DIRECTIVE, $directive->getField());
        $this->assertEquals($expectedValue, (string)$directive->getValue());
    }

    /**
     * @return array
     */
    public function userAgentDirectiveDataProvider()
    {
        return [
            [
                'directiveString' => self::FIELD_USER_AGENT_DIRECTIVE . ':foo',
                'expectedValue' => 'foo',
            ],
            [
                'directiveString' => self::FIELD_USER_AGENT_DIRECTIVE . ':bar',
                'expectedValue' => 'bar',
            ],

        ];
    }

    /**
     * @dataProvider disallowDirectiveDataProvider
     *
     * @param string $directiveString
     * @param string $expectedValue
     */
    public function testCreateDisallowDirective($directiveString, $expectedValue)
    {
        $directive = Factory::create($directiveString);

        $this->assertSame($expectedValue, $directive->getValue()->get());
    }

    /**
     * @return array
     */
    public function disallowDirectiveDataProvider()
    {
        return [
            [
                'directiveString' => self::FIELD_DISALLOW_DIRECTIVE . ':/',
                'expectedValue' => '/',
            ],
            [
                'directiveString' => self::FIELD_DISALLOW_DIRECTIVE . ':',
                'expectedValue' => '',
            ],

        ];
    }
}
