<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\Directive;

class IsValidTest extends DirectiveTest
{
    /**
     * @var Directive
     */
    private $directive;

    protected function setUp()
    {
        parent::setUp();
        $this->directive = new Directive();
    }

    /**
     * @dataProvider validDirectiveStringDataProvider
     *
     * @param string $directiveString
     */
    public function testIsValid($directiveString)
    {
        $this->directive->parse($directiveString);

        $this->assertTrue($this->directive->isValid());
    }

    /**
     * @dataProvider invalidDirectiveStringDataProvider
     *
     * @param $directiveString
     */
    public function testIsNotValid($directiveString)
    {
        $this->directive->parse($directiveString);

        $this->assertFalse($this->directive->isValid());
    }

    /**
     * @return array
     */
    public function validDirectiveStringDataProvider()
    {
        return [
            'field and value' => ['field1:value1'],
            'field and value with space after separator' => ['field: value'],
            'field and value with space before separator' => ['field :value'],
            'field and value with space before and after separator' => ['field : value'],
            'field with empty value' => ['field:']
        ];
    }

    /**
     * @return array
     */
    public function invalidDirectiveStringDataProvider()
    {
        return [
            'no field-value separator' => ['field '],
        ];
    }
}
