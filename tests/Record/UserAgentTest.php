<?php

namespace webignition\Tests\RobotsTxt\Record;

class UserAgentTest extends RecordTest
{
    public function testInclusionOfDefaultUserAgent()
    {
        $this->assertEquals(array('*'), $this->record->userAgentDirectiveList()->getValues());
    }

    public function testAddUserAgent()
    {
        $this->record->userAgentDirectiveList()->add('googlebot');

        $this->assertEquals(array('googlebot'), $this->record->userAgentDirectiveList()->getValues());
    }

    public function testRemoveUserAgent()
    {
        $this->record->userAgentDirectiveList()->add('googlebot');
        $this->record->userAgentDirectiveList()->remove('googlebot');

        $this->assertEquals(array('*'), $this->record->userAgentDirectiveList()->getValues());
    }
}
