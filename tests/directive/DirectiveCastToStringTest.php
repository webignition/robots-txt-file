<?php
ini_set('display_errors', 'On');

class DirectiveCastToStringTest extends PHPUnit_Framework_TestCase {

    public function testCastingToString() { 
        $directive = new \webignition\RobotsTxt\Directive\Directive();
        $directive->parse('allow:/allowed-path');
        
        $this->assertEquals('allow:/allowed-path', (string)$directive);        
    }
    
    public function testCastingListToString() {
        $list = new \webignition\RobotsTxt\DirectiveList\DirectiveList();
        
        $list->add('field1:value1');        
        $this->assertEquals('field1:value1', (string)$list);
        
        $list->add('field2:value2');
        $this->assertEquals('field1:value1'."\n".'field2:value2', (string)$list);        
    }
}