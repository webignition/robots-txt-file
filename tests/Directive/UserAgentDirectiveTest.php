<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Directive;

use webignition\RobotsTxt\Directive\UserAgentDirective;

class UserAgentDirectiveTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var UserAgentDirective
     */
    private $userAgentDirective;

    protected function setUp(): void
    {
        $this->userAgentDirective = new UserAgentDirective('*');
    }

    public function testCastUserAgentDirectiveToString()
    {
        $this->assertEquals('user-agent:*', (string)$this->userAgentDirective);
    }
}
