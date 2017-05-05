<?php

namespace webignition\Tests\RobotsTxt\Directive\Field;

class NameEqualsTest extends FieldTest
{
    public function testFieldNameEquals()
    {
        $this->field->set('allow');
        $this->assertTrue($this->field->equals('allow'));
        $this->assertTrue($this->field->equals('allOw'));
        $this->assertTrue($this->field->equals('aLloW'));
    }
}
