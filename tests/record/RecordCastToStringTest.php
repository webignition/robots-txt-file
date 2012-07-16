<?php
ini_set('display_errors', 'On');

class RecordCastToStringTest extends PHPUnit_Framework_TestCase {
    
    public function testDefaultUserAgentList() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $this->assertEquals('user-agent:*', (string)$record);
    }
    
    public function testMultipleUserAgents() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->userAgentDirectiveList()->add('googlebot');
        $record->userAgentDirectiveList()->add('slurp');
        
        $this->assertEquals('user-agent:googlebot'."\n".'user-agent:slurp', (string)$record);
    }
    
    public function testAllowDisallowOnly() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->directiveList()->add('allow:/allowed-path');
        $record->directiveList()->add('disallow:/disallowed-path');
        
        $this->assertEquals('user-agent:*'."\n".'allow:/allowed-path'."\n".'disallow:/disallowed-path', (string)$record);
    }
    
    public function testMultipleUserAgentsAndAllowDisallow() {
        $record = new \webignition\RobotsTxt\Record\Record();
        
        $record->userAgentDirectiveList()->add('googlebot');
        $record->userAgentDirectiveList()->add('slurp');
        
        $record->directiveList()->add('allow:/allowed-path');
        $record->directiveList()->add('disallow:/disallowed-path');
        
        $this->assertEquals('user-agent:googlebot'."\n".'user-agent:slurp'."\n".'allow:/allowed-path'."\n".'disallow:/disallowed-path', (string)$record);       
    }   
    
}