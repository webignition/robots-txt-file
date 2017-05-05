<?php

namespace webignition\Tests\RobotsTxt\DirectiveList;

use webignition\Tests\RobotsTxt\BaseTest;
use webignition\RobotsTxt\DirectiveList\DirectiveList;

abstract class DirectiveListTest extends BaseTest
{
    /**
     * @var DirectiveList
     */
    protected $directiveList;

    public function setUp()
    {
        $this->directiveList = new DirectiveList();
    }
}
