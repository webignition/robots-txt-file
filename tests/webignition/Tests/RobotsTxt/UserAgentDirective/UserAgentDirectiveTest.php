<?php

namespace webignition\Tests\RobotsTxt\UserAgentDirective;

use webignition\Tests\RobotsTxt\BaseTest;
use webignition\RobotsTxt\UserAgentDirective\UserAgentDirective;

abstract class UserAgentDirectiveTest extends BaseTest {

    /**
     * @var UserAgentDirective
     */
    protected $userAgentDirective;

    public function setUp() {
        $this->userAgentDirective = new UserAgentDirective();
    }
    
}