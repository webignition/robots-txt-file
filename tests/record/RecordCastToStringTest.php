<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class RecordDirectiveTest extends PHPUnit_Framework_TestCase {
    
    public function testDefaultDirectiveList() {         
        $record = new \webignition\RobotsTxt\Record\Record();
       
        $this->assertEquals(array(), $record->directiveList()->get());
    }
    
    public function testAddDirective() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->directiveList()->add('allow', '/allowed-path');
        
        $this->assertEquals(array('allow:/allowed-path'), $record->directiveList()->get());
    }
    
    public function testRemoveDirective() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->directiveList()->add('allow', '/allowed-path');
        $record->directiveList()->remove('allow', '/allowed-path');
        
        $this->assertEquals(array(), $record->directiveList()->get());
    }    
    
}