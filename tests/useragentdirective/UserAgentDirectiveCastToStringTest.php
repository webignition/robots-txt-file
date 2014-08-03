<?php

class UserAgentDirectiveCastToStringTest extends PHPUnit_Framework_TestCase
{
    public function testCastUserAgentDirectiveToString()
    {
        $userAgentDirective = new \webignition\RobotsTxt\UserAgentDirective\UserAgentDirective();

        $this->assertEquals('user-agent:*', (string) $userAgentDirective);
    }
}
