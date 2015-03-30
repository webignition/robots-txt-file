<?php

namespace webignition\Tests\RobotsTxt\Directive\Field;

class ValueSeparatorIsIgnoredTest extends FieldTest {
    
    public function testFieldValueSeparatorIsIgnored() {
        $this->field->set('allow:ignored');
        $this->assertEquals('allow', $this->field->get());
    }
}