<?php

namespace webignition\Tests\RobotsTxt\Directive\Field;

class NameIsCaseInsensitiveTest extends FieldTest
{
    public function testFieldNameIsCaseInsensitive()
    {
        $this->field->set('allow');
        $this->assertEquals('allow', $this->field->get());

        $this->field->set('ALLOW');
        $this->assertEquals('allow', $this->field->get());

        $this->field->set('aLLow');
        $this->assertEquals('allow', $this->field->get());

        $this->field->set('allOW');
        $this->assertEquals('allow', $this->field->get());
    }
}
