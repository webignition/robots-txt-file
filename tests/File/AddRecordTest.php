<?php

namespace webignition\Tests\RobotsTxt\File;

use webignition\RobotsTxt\Record\Record;

class AddRecordTest extends FileTest
{
    public function testAddRecord()
    {
        $record = new Record();
        $record->directiveList()->add('allow:/allowed-path');

        $this->file->addRecord($record);

        $fileRecords = $this->file->getRecords();

        $this->assertEquals(1, count($fileRecords));
        $this->assertTrue($fileRecords[0] instanceof Record);
    }
}
