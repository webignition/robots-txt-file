<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class UserAgentDirectiveListTest extends PHPUnit_Framework_TestCase {
    
    public function testAdd() {         
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->userAgentDirectiveList()->add('googlebot');        
        $this->assertEquals(array('googlebot'), $record->userAgentDirectiveList()->get());
        
        $record->userAgentDirectiveList()->add('slurp');
        $this->assertEquals(array('googlebot', 'slurp'), $record->userAgentDirectiveList()->get());
    }
    
    public function testRemove() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->userAgentDirectiveList()->add('agent1');                
        $record->userAgentDirectiveList()->add('agent2');
        $record->userAgentDirectiveList()->add('agent3');        
        $this->assertEquals(array('agent1', 'agent2', 'agent3'), $record->userAgentDirectiveList()->get());
        
        $record->userAgentDirectiveList()->remove('agent1');
        $this->assertEquals(array('agent2', 'agent3'), $record->userAgentDirectiveList()->get());
        
        $record->userAgentDirectiveList()->remove('agent2');
        $this->assertEquals(array('agent3'), $record->userAgentDirectiveList()->get());
        
        $record->userAgentDirectiveList()->remove('agent3');
        $this->assertEquals(array('*'), $record->userAgentDirectiveList()->get());        
    }
    
    public function testContains() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->userAgentDirectiveList()->add('agent1');                
        $record->userAgentDirectiveList()->add('agent2');
        $record->userAgentDirectiveList()->add('agent3');
        
        $this->assertTrue($record->userAgentDirectiveList()->contains('agent1'));
        $this->assertTrue($record->userAgentDirectiveList()->contains('agent2'));
        $this->assertTrue($record->userAgentDirectiveList()->contains('agent3'));
        $this->assertFalse($record->userAgentDirectiveList()->contains('doesnotcontain'));
    }
    
}