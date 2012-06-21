<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class DirectiveListTest extends PHPUnit_Framework_TestCase {
    
    public function testAdd() {
        $directiveList = new \webignition\RobotsTxt\Directive\DirectiveList();
        
        $directiveList->add('allow', '/allowed-path');        
        $this->assertEquals(array('allow:/allowed-path'), $directiveList->getValues());
        
        $directiveList->add('disallow', '/disallowed-path');
        $this->assertEquals(array('allow:/allowed-path', 'disallow:/disallowed-path'), $directiveList->getValues());
    }
    
    public function testRemove() {
        $directiveList = new \webignition\RobotsTxt\Directive\DirectiveList();
        
        $directiveList->add('field1', 'value1');                
        $directiveList->add('field2', 'value2');
        $directiveList->add('field3', 'value3');        
        $this->assertEquals(array('field1:value1', 'field2:value2', 'field3:value3'), $directiveList->getValues());
        
        $directiveList->remove('fieLD1', 'value1');
        $this->assertEquals(array('field2:value2', 'field3:value3'), $directiveList->getValues());
        
        $directiveList->remove('field2', 'value2');
        $this->assertEquals(array('field3:value3'), $directiveList->getValues());
        
        $directiveList->remove('fielD3', 'value3');
        $this->assertEquals(array(), $directiveList->getValues());        
    }
    
    public function testContains() {
        $directiveList = new \webignition\RobotsTxt\Directive\DirectiveList();
        
        $directiveList->add('field1', 'value1');                
        $directiveList->add('field2', 'value2');
        $directiveList->add('field3', 'value3'); 
        
        $this->assertTrue($directiveList->contains('field1', 'value1'));
        $this->assertTrue($directiveList->contains('fIeld2', 'value2'));
        $this->assertTrue($directiveList->contains('fiELd3', 'value3'));        
        $this->assertFalse($directiveList->contains('doesnotcontain', 'value'));
    }
    
}