<?php

namespace webignition\Tests\RobotsTxt\Directive\Field;

class CommentIsIgnoredTest extends FieldTest {

    public function testCommentIsIgnored() {
        $this->field->set('value2 # this comment should be ignored');
        $this->assertEquals('value2', $this->field->get());
    }    
}