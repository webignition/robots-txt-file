<?php

namespace webignition\Tests\RobotsTxt\Directive\Field;

use webignition\Tests\RobotsTxt\Directive\DirectiveTest;
use webignition\RobotsTxt\Directive\Field;

abstract class FieldTest extends DirectiveTest
{
    /**
     * @var Field
     */
    protected $field;

    protected function setUp()
    {
        $this->field = new Field();
    }

    /**
     * @return array
     */
    public function mixedCaseFieldNameProvider()
    {
        return [
            ['allow'],
            ['ALLOW'],
            ['aLLow'],
            ['allOW'],
        ];
    }
}
