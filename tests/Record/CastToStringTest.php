<?php

namespace webignition\Tests\RobotsTxt\Record;

class CastToStringTest extends RecordTest
{
    public function testDefaultUserAgentList()
    {
        $this->assertEquals('user-agent:*', (string)$this->record);
    }

    public function testMultipleUserAgents()
    {
        $this->record->userAgentDirectiveList()->add('googlebot');
        $this->record->userAgentDirectiveList()->add('slurp');

        $this->assertEquals('user-agent:googlebot'."\n".'user-agent:slurp', (string)$this->record);
    }

    public function testAllowDisallowOnly()
    {
        $this->record->directiveList()->add('allow:/allowed-path');
        $this->record->directiveList()->add('disallow:/disallowed-path');

        $this->assertEquals(
            'user-agent:*'."\n".'allow:/allowed-path'."\n".'disallow:/disallowed-path',
            (string)$this->record
        );
    }

    public function testMultipleUserAgentsAndAllowDisallow()
    {
        $this->record->userAgentDirectiveList()->add('googlebot');
        $this->record->userAgentDirectiveList()->add('slurp');

        $this->record->directiveList()->add('allow:/allowed-path');
        $this->record->directiveList()->add('disallow:/disallowed-path');

        $this->assertEquals(
            'user-agent:googlebot'."\n".'user-agent:slurp'."\n".'allow:/allowed-path'."\n".'disallow:/disallowed-path',
            (string)$this->record
        );
    }
}
