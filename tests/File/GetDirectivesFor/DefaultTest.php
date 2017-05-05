<?php

namespace webignition\Tests\RobotsTxt\File\GetDirectivesFor;

use webignition\RobotsTxt\Record\Record;

class DefaultTest extends GetDirectivesForTest
{
    public function testGetDirectivesFor()
    {

        $record1 = new Record();
        $record1->userAgentDirectiveList()->add('*');
        $record1->directiveList()->add('allow:/allowed-path-for-*');
        $record1->directiveList()->add('disallow:/disallowed-path-for-*');

        $record2 = new Record();
        $record2->userAgentDirectiveList()->add('googlebot');
        $record2->directiveList()->add('allow:/allowed-path-for-googlebot');
        $record2->directiveList()->add('disallow:/disallowed-path-for-googlebot');

        $this->file->addRecord($record1);
        $this->file->addRecord($record2);

        $this->assertEquals(
            'allow:/allowed-path-for-googlebot'."\n".'disallow:/disallowed-path-for-googlebot',
            (string)$this->file->getDirectivesFor('googlebot')
        );

        $this->assertEquals(
            'allow:/allowed-path-for-*'."\n".'disallow:/disallowed-path-for-*',
            (string)$this->file->getDirectivesFor('*')
        );

        $this->assertEquals(
            'allow:/allowed-path-for-*'."\n".'disallow:/disallowed-path-for-*',
            (string)$this->file->getDirectivesFor('slurp')
        );
    }
}
