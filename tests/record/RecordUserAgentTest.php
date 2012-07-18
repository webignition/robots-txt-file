<?php

class RecordUserAgentTest extends PHPUnit_Framework_TestCase {
    
    public function testInclusionOfDefaultUserAgent() {         
        $record = new \webignition\RobotsTxt\Record\Record();
       
        $this->assertEquals(array('*'), $record->userAgentDirectiveList()->getValues());
    }
    
    public function testAddUserAgent() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->userAgentDirectiveList()->add('googlebot');
        
        $this->assertEquals(array('googlebot'), $record->userAgentDirectiveList()->getValues());
    }
    
    public function testRemoveUserAgent() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->userAgentDirectiveList()->add('googlebot');
        $record->userAgentDirectiveList()->remove('googlebot');
        
        $this->assertEquals(array('*'), $record->userAgentDirectiveList()->getValues());
    }    
    
}