<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class RecordUserAgentTest extends PHPUnit_Framework_TestCase {
    
    public function testInclusionOfDefaultUserAgent() {         
        $record = new \webignition\RobotsTxt\Record\Record();
       
        $this->assertEquals(array('*'), $record->getUserAgentList());
    }
    
    public function testAddUserAgent() {         
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->addUserAgent('googlebot');        
        $this->assertEquals(array('googlebot'), $record->getUserAgentList());
        
        $record->addUserAgent('slurp');
        $this->assertEquals(array('googlebot', 'slurp'), $record->getUserAgentList());
    }
    
    public function testRemoveUserAgent() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->addUserAgent('agent1');                
        $record->addUserAgent('agent2');
        $record->addUserAgent('agent3');        
        $this->assertEquals(array('agent1', 'agent2', 'agent3'), $record->getUserAgentList());
        
        $record->removeUserAgent('agent1');
        $this->assertEquals(array('agent2', 'agent3'), $record->getUserAgentList());
        
        $record->removeUserAgent('agent2');
        $this->assertEquals(array('agent3'), $record->getUserAgentList());
        
        $record->removeUserAgent('agent3');
        $this->assertEquals(array('*'), $record->getUserAgentList());        
    }
    
    public function testContains() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->addUserAgent('agent1');                
        $record->addUserAgent('agent2');
        $record->addUserAgent('agent3');
        
        $this->assertTrue($record->containsUserAgent('agent1'));
        $this->assertTrue($record->containsUserAgent('agent2'));
        $this->assertTrue($record->containsUserAgent('agent3'));
        $this->assertFalse($record->containsUserAgent('doesnotcontain'));
    }
    
    
}