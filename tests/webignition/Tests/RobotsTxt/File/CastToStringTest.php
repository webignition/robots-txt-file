<?php

namespace webignition\Tests\RobotsTxt\File;

use webignition\RobotsTxt\Record\Record;

class CastToStringTest extends FileTest
{
    public function testCastingToStringWithDefaultUserAgent()
    {
        $record = new Record();
        $record->directiveList()->add('allow:/allowed-path');

        $this->file->addRecord($record);

        $this->assertEquals('user-agent:*'."\n".'allow:/allowed-path', (string)$this->file);
    }

    public function testCastingToStringWithSpecificUserAgent()
    {
        $record = new Record();
        $record->directiveList()->add('allow:/allowed-path');
        $record->userAgentDirectiveList()->add('googlebot');

        $this->file->addRecord($record);

        $this->assertEquals('user-agent:googlebot'."\n".'allow:/allowed-path', (string)$this->file);
    }

    public function testWithMultipleRecords()
    {
        $record1 = new Record();
        $record1->directiveList()->add('allow:/allowed-path');
        $record1->userAgentDirectiveList()->add('googlebot');

        $record2 = new Record();
        $record2->directiveList()->add('disallow:/');
        $record2->userAgentDirectiveList()->add('slurp');

        $this->file->addRecord($record1);
        $this->file->addRecord($record2);

        $this->assertEquals(
            'user-agent:googlebot'."\n".'allow:/allowed-path'."\n\n".'user-agent:slurp'."\n".'disallow:/',
            (string)$this->file
        );
    }

    public function testCastingWithDirectivesOnly()
    {
        $this->file->directiveList()->add('sitemap:http://www.example.com/sitemap.xml');

        $this->assertEquals('sitemap:http://www.example.com/sitemap.xml', (string)$this->file);
    }
}
