<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../../lib/bootstrap.php');

class FileAddRecordTest extends PHPUnit_Framework_TestCase {

    public function testAddRecord() {
        $record = new \webignition\RobotsTxt\Record\Record();
        $record->directiveList()->add('allow:/allowed-path');
        
        $file = new \webignition\RobotsTxt\File\File();
        $file->addRecord($record);
        
        $fileRecords = $file->getRecords();
        
        $this->assertEquals(1, count($fileRecords));        
        $this->assertTrue($fileRecords[0] instanceof \webignition\RobotsTxt\Record\Record);
    }
}