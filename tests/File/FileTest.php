<?php

namespace webignition\Tests\RobotsTxt\File;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\Record\Record;
use webignition\RobotsTxt\Directive\UserAgentDirective;

class FileTest extends AbstractFileTest
{
    public function testAddRecord()
    {
        $record = new Record();
        $record->directiveList()->add(new Directive('allow', '/allowed-path'));

        $this->file->addRecord($record);

        $fileRecords = $this->file->getRecords();

        $this->assertCount(1, $fileRecords);
        $this->assertInstanceOf(Record::class, $fileRecords[0]);
    }

    public function testCastToStringWithDefaultUserAgent()
    {
        $record = new Record();
        $record->directiveList()->add(new Directive('allow', '/allowed-path'));

        $this->file->addRecord($record);

        $this->assertEquals('user-agent:*'."\n".'allow:/allowed-path', (string)$this->file);
    }

    public function testCastToStringWithSpecificUserAgent()
    {
        $record = new Record();
        $record->directiveList()->add(new Directive('allow', '/allowed-path'));
        $record->userAgentDirectiveList()->add(new UserAgentDirective('googlebot'));

        $this->file->addRecord($record);

        $this->assertEquals('user-agent:googlebot'."\n".'allow:/allowed-path', (string)$this->file);
    }

    public function testCastToStringWithMultipleRecords()
    {
        $record1 = new Record();
        $record1->directiveList()->add(new Directive('allow', '/allowed-path'));
        $record1->userAgentDirectiveList()->add(new UserAgentDirective('googlebot'));

        $record2 = new Record();
        $record2->directiveList()->add(new Directive('disallow', '/'));
        $record2->userAgentDirectiveList()->add(new UserAgentDirective(('slurp')));

        $this->file->addRecord($record1);
        $this->file->addRecord($record2);

        $this->assertEquals(
            'user-agent:googlebot'."\n".'allow:/allowed-path'."\n\n".'user-agent:slurp'."\n".'disallow:/',
            (string)$this->file
        );
    }

    public function testCastToStringWithDirectivesOnly()
    {
        $this->file->directiveList()->add(new Directive('sitemap', 'http://www.example.com/sitemap.xml'));

        $this->assertEquals('sitemap:http://www.example.com/sitemap.xml', (string)$this->file);
    }
}
