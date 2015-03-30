<?php

namespace webignition\Tests\RobotsTxt\UserAgentDirective;

class CastToStringTest extends UserAgentDirectiveTest {

    public function testCastUserAgentDirectiveToString() {
        $this->assertEquals('user-agent:*', (string)$this->userAgentDirective);
    }
}