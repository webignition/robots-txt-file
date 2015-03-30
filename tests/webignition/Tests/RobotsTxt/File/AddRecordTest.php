<?php

namespace webignition\Tests\RobotsTxt\File;

use webignition\RobotsTxt\Record\Record;

class AddRecordTest extends FileTest {

    public function testAddRecord() {
        $record = new Record();
        $record->directiveList()->add('allow:/allowed-path');
        
        $this->file->addRecord($record);

        $this->assertEquals(1, count($this->file->getRecords()));
        $this->assertTrue($this->file->getRecords()[0] instanceof Record);
    }
}