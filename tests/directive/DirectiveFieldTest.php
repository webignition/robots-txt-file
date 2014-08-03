<?php

class DirectiveFieldTest extends PHPUnit_Framework_TestCase
{
    public function testFieldValueSeparatorIsIgnored()
    {
        $directiveField = new \webignition\RobotsTxt\Directive\Field();

        $directiveField->set('allow:ignored');
        $this->assertEquals('allow', $directiveField->get());
    }

    public function testFieldNameIsCaseInsensitive()
    {
        $directiveField = new \webignition\RobotsTxt\Directive\Field();

        $directiveField->set('allow');
        $this->assertEquals('allow', $directiveField->get());

        $directiveField->set('ALLOW');
        $this->assertEquals('allow', $directiveField->get());

        $directiveField->set('aLLow');
        $this->assertEquals('allow', $directiveField->get());

        $directiveField->set('allOW');
        $this->assertEquals('allow', $directiveField->get());
    }

    public function testFieldNameEquals()
    {
        $directiveField = new \webignition\RobotsTxt\Directive\Field();

        $directiveField->set('allow');
        $this->assertTrue($directiveField->equals('allow'));
        $this->assertTrue($directiveField->equals('allOw'));
        $this->assertTrue($directiveField->equals('aLloW'));
    }
}
