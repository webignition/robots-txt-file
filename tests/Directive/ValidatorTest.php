<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Directive;

use webignition\RobotsTxt\Directive\Validator;

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider validDirectiveDataProvider
     */
    public function testIsValid(string $directiveString)
    {
        $this->assertTrue(Validator::isDirectiveStringValid($directiveString));
    }

    public function validDirectiveDataProvider(): array
    {
        return [
            'generic field only' => [
                'directiveString' => 'foo:',
            ],
            'generic field and value' => [
                'directiveString' => 'foo:bar',
            ],
            'generic field only with comment' => [
                'directiveString' => 'foo: # comment',
            ],
            'generic field and value with comment' => [
                'directiveString' => 'foo:bar # comment',
            ],
        ];
    }

    /**
     * @dataProvider invalidDirectiveDataProvider
     */
    public function testIsNotValid(string $directiveString)
    {
        $this->assertFalse(Validator::isDirectiveStringValid($directiveString));
    }

    public function invalidDirectiveDataProvider(): array
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
}
