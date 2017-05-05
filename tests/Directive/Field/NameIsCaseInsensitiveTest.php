<?php

namespace webignition\Tests\RobotsTxt\Directive\Field;

class NameIsCaseInsensitiveTest extends FieldTest
{
    /**
     * @dataProvider mixedCaseFieldNameProvider
     *
     * @param string $fieldName
     */
    public function testFieldNameIsCaseInsensitive($fieldName)
    {
        $this->field->set($fieldName);
        $this->assertEquals('allow', $this->field->get());
    }
}
