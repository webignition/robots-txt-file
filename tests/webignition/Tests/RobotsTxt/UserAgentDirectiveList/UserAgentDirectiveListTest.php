<?php

namespace webignition\Tests\RobotsTxt\UserAgentDirectiveList;

use webignition\Tests\RobotsTxt\BaseTest;
use webignition\RobotsTxt\UserAgentDirective\UserAgentDirectiveList;

abstract class UserAgentDirectiveListTest extends BaseTest {

    /**
     * @var UserAgentDirectiveList
     */
    protected $userAgentDirectiveList;

    public function setUp() {
        $this->userAgentDirectiveList = new UserAgentDirectiveList();
    }

}