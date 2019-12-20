<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Directive;

use webignition\RobotsTxt\Directive\Factory;
use webignition\RobotsTxt\Directive\UserAgentDirective;

class FactoryTest extends \PHPUnit\Framework\TestCase
{
    private const FIELD_USER_AGENT_DIRECTIVE = 'user-agent';
    private const FIELD_DISALLOW_DIRECTIVE = 'disallow';

    /**
     * @dataProvider invalidDirectiveStringDataProvider
     */
    public function testCreateFromInvalidDirectiveString(string $directiveString)
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
     */
    public function testCreateUserAgentDirective(string $directiveString, string $expectedValue)
    {
        $directive = Factory::create($directiveString);
        $this->assertInstanceOf(UserAgentDirective::class, $directive);

        $this->assertEquals(self::FIELD_USER_AGENT_DIRECTIVE, $directive->getField());
        $this->assertEquals($expectedValue, (string)$directive->getValue());
    }

    public function userAgentDirectiveDataProvider(): array
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
     */
    public function testCreateDisallowDirective(string $directiveString, string $expectedValue)
    {
        $directive = Factory::create($directiveString);

        $this->assertSame($expectedValue, $directive->getValue()->get());
    }

    public function disallowDirectiveDataProvider(): array
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
