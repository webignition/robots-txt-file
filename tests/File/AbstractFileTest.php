<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\File;

use webignition\RobotsTxt\File\File;

abstract class AbstractFileTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var File
     */
    protected $file;

    protected function setUp(): void
    {
        $this->file = new File();
    }
}
