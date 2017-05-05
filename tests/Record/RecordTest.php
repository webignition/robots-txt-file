<?php

namespace webignition\Tests\RobotsTxt\Record;

use webignition\Tests\RobotsTxt\BaseTest;
use webignition\RobotsTxt\Record\Record;

abstract class RecordTest extends BaseTest
{
    /**
     * @var Record
     */
    protected $record;

    protected function setUp()
    {
        $this->record = new Record();
    }
}
