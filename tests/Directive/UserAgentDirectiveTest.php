<?php

namespace webignition\Tests\RobotsTxt\Directive;

use webignition\RobotsTxt\Directive\UserAgentDirective;
use webignition\Tests\RobotsTxt\BaseTest;

class UserAgentDirectiveTest extends BaseTest
{
    /**
     * @var UserAgentDirective
     */
    private $userAgentDirective;

    protected function setUp()
    {
        $this->userAgentDirective = new UserAgentDirective('*');
    }

    public function testCastUserAgentDirectiveToString()
    {
        $this->assertEquals('user-agent:*', (string)$this->userAgentDirective);
    }
}
