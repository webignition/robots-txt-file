<?php
ini_set('display_errors', 'On');

class UserAgentDirectiveListTest extends PHPUnit_Framework_TestCase {
    
    public function testAdd() {
        $userAgentDirectiveList = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList();
        
        $userAgentDirectiveList->add('googlebot');        
        $this->assertEquals(array('googlebot'), $userAgentDirectiveList->getValues());
        
        $userAgentDirectiveList->add('slURp');
        $this->assertEquals(array('googlebot', 'slurp'), $userAgentDirectiveList->getValues());
    }
    
    public function testRemove() {
        $userAgentDirectiveList = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList();
        
        $userAgentDirectiveList->add('agent1');                
        $userAgentDirectiveList->add('agent2');
        $userAgentDirectiveList->add('agent3');   
        
        $this->assertEquals(array('agent1', 'agent2', 'agent3'), $userAgentDirectiveList->getValues());
        
        $userAgentDirectiveList->remove('aGEnt1');
        $this->assertEquals(array('agent2', 'agent3'), $userAgentDirectiveList->getValues());
        
        $userAgentDirectiveList->remove('agent2');
        $this->assertEquals(array('agent3'), $userAgentDirectiveList->getValues());
        
        $userAgentDirectiveList->remove('agent3');
        $this->assertEquals(array('*'), $userAgentDirectiveList->getValues());        
    }
    
    public function testContains() {
        $userAgentDirectiveList = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList();
        
        $userAgentDirectiveList->add('agent1');                
        $userAgentDirectiveList->add('agent2');
        $userAgentDirectiveList->add('AGent3');
        
        $this->assertTrue($userAgentDirectiveList->contains('agent1'));
        $this->assertTrue($userAgentDirectiveList->contains('agent2'));
        $this->assertTrue($userAgentDirectiveList->contains('agent3'));
        $this->assertFalse($userAgentDirectiveList->contains('doesnotcontain'));
    }
    
}