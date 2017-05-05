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

    public function setUp()
    {
        $this->field = new Field();
    }
}
