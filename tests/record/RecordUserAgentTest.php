<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class RecordUserAgentTest extends PHPUnit_Framework_TestCase {
    
    public function testInclusionOfDefaultUserAgent() {         
        $record = new \webignition\RobotsTxt\Record\Record();
       
        $this->assertEquals(array('*'), $record->getUserAgentList());
    }
    
}