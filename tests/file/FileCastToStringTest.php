<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class FileCastToStringTest extends PHPUnit_Framework_TestCase {

    public function testCastingToStringWithDefaultUserAgent() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->directiveList()->add('allow:/allowed-path');
        
        $file = new \webignition\RobotsTxt\File\File();
        $file->addRecord($record);
        
        $this->assertEquals('user-agent:*'."\n".'allow:/allowed-path', (string)$file);
    }
    
    public function testCastingToStringWithSpecificUserAgent() {
        $record = new \webignition\RobotsTxt\Record\Record();        
        $record->directiveList()->add('allow:/allowed-path');
        $record->userAgentDirectiveList()->add('googlebot');
        
        $file = new \webignition\RobotsTxt\File\File();
        $file->addRecord($record);
        
        $this->assertEquals('user-agent:googlebot'."\n".'allow:/allowed-path', (string)$file);
    }    
    
    public function testWithMultipleRecords() {
        $record1 = new \webignition\RobotsTxt\Record\Record();
        $record1->directiveList()->add('allow:/allowed-path');
        $record1->userAgentDirectiveList()->add('googlebot');        
        
        $record2 = new \webignition\RobotsTxt\Record\Record();
        $record2->directiveList()->add('disallow:/');
        $record2->userAgentDirectiveList()->add('slurp');
        
        $file = new \webignition\RobotsTxt\File\File();
        $file->addRecord($record1);
        $file->addRecord($record2);
        
        $this->assertEquals('user-agent:googlebot'."\n".'allow:/allowed-path'."\n\n".'user-agent:slurp'."\n".'disallow:/', (string)$file);        
    }
}