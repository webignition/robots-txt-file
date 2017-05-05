<?php

namespace webignition\Tests\RobotsTxt\Directive\Field;

class NameEqualsTest extends FieldTest
{
    /**
     * @dataProvider mixedCaseFieldNameProvider
     *
     * @param string $fieldName
     */
    public function testFieldNameEquals($fieldName)
    {
        $this->field->set('allow');
        $this->assertTrue($this->field->equals($fieldName));
    }
}
