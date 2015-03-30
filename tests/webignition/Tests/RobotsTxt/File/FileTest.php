<?php

namespace webignition\Tests\RobotsTxt\File;

use webignition\Tests\RobotsTxt\BaseTest;
use webignition\RobotsTxt\File\File;

abstract class FileTest extends BaseTest {

    /**
     * @var File
     */
    protected $file;

    public function setUp() {
        $this->file = new File();
    }


}