<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Record;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\Directive\UserAgentDirective;
use webignition\RobotsTxt\Record\Record;

class RecordTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Record
     */
    private $record;

    protected function setUp(): void
    {
        $this->record = new Record();
    }

    public function testCastToStringWithDefaultUserAgentList()
    {
        $this->assertEquals('user-agent:*', (string)$this->record);
    }

    public function testCastToStringWithMultipleUserAgents()
    {
        $this->record->getUserAgentDirectiveList()->add(new UserAgentDirective('googlebot'));
        $this->record->getUserAgentDirectiveList()->add(new UserAgentDirective('slurp'));

        $this->assertEquals('user-agent:googlebot' . "\n" . 'user-agent:slurp', (string)$this->record);
    }

    public function testCastToStringWithAllowDisallowOnly()
    {
        $this->record->getDirectiveList()->add(new Directive('allow', '/allowed-path'));
        $this->record->getDirectiveList()->add(new Directive('disallow', '/disallowed-path'));

        $this->assertEquals(
            'user-agent:*' . "\n" . 'allow:/allowed-path' . "\n" . 'disallow:/disallowed-path',
            (string)$this->record
        );
    }

    public function testCastToStringWithMultipleUserAgentsAndAllowDisallow()
    {
        $this->record->getUserAgentDirectiveList()->add(new UserAgentDirective('googlebot'));
        $this->record->getUserAgentDirectiveList()->add(new UserAgentDirective('slurp'));

        $this->record->getDirectiveList()->add(new Directive('allow', '/allowed-path'));
        $this->record->getDirectiveList()->add(new Directive('disallow', '/disallowed-path'));

        $this->assertEquals(
            'user-agent:googlebot' . "\n" .
            'user-agent:slurp' . "\n" .
            'allow:/allowed-path' . "\n" .
            'disallow:/disallowed-path',
            (string)$this->record
        );
    }

    public function testInclusionOfDefaultUserAgent()
    {
        $this->assertEquals(array('*'), $this->record->getUserAgentDirectiveList()->getValues());
    }

    public function testAddUserAgent()
    {
        $this->record->getUserAgentDirectiveList()->add(new UserAgentDirective('googlebot'));

        $this->assertEquals(array('googlebot'), $this->record->getUserAgentDirectiveList()->getValues());
    }

    public function testRemoveUserAgent()
    {
        $googlebotDirective = new UserAgentDirective('googlebot');

        $this->record->getUserAgentDirectiveList()->add($googlebotDirective);
        $this->record->getUserAgentDirectiveList()->remove($googlebotDirective);

        $this->assertEquals(array('*'), $this->record->getUserAgentDirectiveList()->getValues());
    }
}
