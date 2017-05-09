<?php

namespace webignition\Tests\RobotsTxt\Factory;

use webignition\RobotsTxt\Directive\Validator;
use webignition\Tests\RobotsTxt\BaseTest;

class ValidatorTest extends BaseTest
{
    /**
     * @dataProvider validDirectiveDataProvider
     *
     * @param string $directiveString
     */
    public function testIsValid($directiveString)
    {
        $this->assertTrue(Validator::isDirectiveStringValid($directiveString));
    }

    /**
     * @return array
     */
    public function validDirectiveDataProvider()
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
     *
     * @param string $directiveString
     */
    public function testIsNotValid($directiveString)
    {
        $this->assertFalse(Validator::isDirectiveStringValid($directiveString));
    }

    /**
     * @return array
     */
    public function invalidDirectiveDataProvider()
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
