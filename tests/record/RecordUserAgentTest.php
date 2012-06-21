<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class RecordUserAgentTest extends PHPUnit_Framework_TestCase {
    
    public function testInclusionOfDefaultUserAgent() {         
        $record = new \webignition\RobotsTxt\Record\Record();
       
        $this->assertEquals(array('*'), $record->userAgentDirectiveList()->get());
    }
    
    public function testAddUserAgent() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->userAgentDirectiveList()->add('googlebot');
        
        $this->assertEquals(array('googlebot'), $record->userAgentDirectiveList()->get());
    }
    
    public function testRemoveUserAgent() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->userAgentDirectiveList()->add('googlebot');
        $record->userAgentDirectiveList()->remove('googlebot');
        
        $this->assertEquals(array('*'), $record->userAgentDirectiveList()->get());
    }    
    
}