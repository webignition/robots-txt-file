<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class DirectiveValueTest extends PHPUnit_Framework_TestCase {

    public function testSetGetValidValues() {        
        $directiveValue = new \webignition\RobotsTxt\Directive\Value();
        
        $directiveValue->set('value1');        
        $this->assertEquals('value1', $directiveValue->get());
        
        $directiveValue->set('value2');
        $this->assertEquals('value2', $directiveValue->get());        
    }
    
    public function testCommentIsIgnored() {
        $directiveField = new \webignition\RobotsTxt\Directive\Field();
        
        $directiveField->set('value2 # this comment should be ignored');        
        $this->assertEquals('value2', $directiveField->get());       
    }    
}