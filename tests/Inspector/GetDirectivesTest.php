<?php

declare(strict_types=1);

namespace webignition\RobotsTxt\Tests\Inspector;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\File\File;
use webignition\RobotsTxt\Inspector\Inspector;
use webignition\RobotsTxt\Record\Record;
use webignition\RobotsTxt\Directive\UserAgentDirective;

class GetDirectivesTest extends \PHPUnit\Framework\TestCase
{
    private const FIELD_ALLOW = 'allow';
    private const FIELD_DISALLOW = 'disallow';
    private const VALUE_ALL_AGENTS_0 = '/allowed-path-for-*';
    private const VALUE_ALL_AGENTS_1 = '/disallowed-path-for-*';
    private const VALUE_GOOGLEBOT_0 = '/allowed-path-for-googlebot';
    private const VALUE_GOOGLEBOT_1 = '/disallowed-path-for-googlebot';
    private const VALUE_GOOGLEBOT_NEWS_0 = '/allowed-path-for-googlebot-news';
    private const VALUE_GOOGLEBOT_NEWS_1 = '/disallowed-path-for-googlebot-news';
    private const VALUE_BINGBOT_SLURP_0 = '/allowed-path-for-bingbot-slurp';
    private const VALUE_BINGBOT_SLURP_1 = '/disallowed-path-for-bingbot-slurp';

    /**
     * @var array<string, string>
     */
    private $userAgentStringFixtures = [];

    /**
     * @var File
     */
    protected $file;

    protected function setUp(): void
    {
        $this->file = new File();
    }

    /**
     * @dataProvider getDirectivesForDefaultFileDataProvider
     */
    public function testGetDirectivesForDefaultFile(string $userAgentString, string $expectedDirectives)
    {
        $this->createDefaultFile();
        $inspector = new Inspector($this->file);
        $inspector->setUserAgent($userAgentString);

        $this->assertEquals(
            $expectedDirectives,
            (string) $inspector->getDirectives()
        );
    }

    public function getDirectivesForDefaultFileDataProvider(): array
    {
        return [
            'googlebot-lowercase' => [
                'userAgentString' => 'googlebot',
                'expectedDirectives' => implode("\n", $this->getExpectedGooglebotDirectives())
            ],
            'googlebot-uppercase' => [
                'userAgentString' => 'GOOGLEBOT',
                'expectedDirectives' => implode("\n", $this->getExpectedGooglebotDirectives())
            ],
            'googlebot-mixedcase' => [
                'userAgentString' => 'GOOGLEbot',
                'expectedDirectives' => implode("\n", $this->getExpectedGooglebotDirectives())
            ],
            'googlebot-news' => [
                'userAgentString' => 'googlebot-news',
                'expectedDirectives' => implode("\n", $this->getExpectedGooglebotNewsDirectives())
            ],
            'no specific agent' => [
                'userAgentString' => '*',
                'expectedDirectives' => implode("\n", $this->getExpectedAllAgentsDirectives())
            ],
            'specific agent not present' => [
                'userAgentString' => 'foo',
                'expectedDirectives' => implode("\n", $this->getExpectedAllAgentsDirectives())
            ],
            'full googlebot string variant 1' => [
                'userAgentString' => $this->getUserAgentStringFixture('googlebot-1'),
                'expectedDirectives' => implode("\n", $this->getExpectedGooglebotDirectives())
            ],
            'full googlebot string variant 2' => [
                'userAgentString' => $this->getUserAgentStringFixture('googlebot-2'),
                'expectedDirectives' => implode("\n", $this->getExpectedGooglebotDirectives())
            ],
            'bingbot variant 1' => [
                'userAgentString' => $this->getUserAgentStringFixture('bingbot-1'),
                'expectedDirectives' => implode("\n", $this->getExpectedBingbotSlurpDirectives())
            ],
            'bingbot variant 2' => [
                'userAgentString' => $this->getUserAgentStringFixture('bingbot-2'),
                'expectedDirectives' => implode("\n", $this->getExpectedBingbotSlurpDirectives())
            ],
            'bingbot variant 3' => [
                'userAgentString' => $this->getUserAgentStringFixture('bingbot-3'),
                'expectedDirectives' => implode("\n", $this->getExpectedBingbotSlurpDirectives())
            ],
            'slurp' => [
                'userAgentString' => $this->getUserAgentStringFixture('slurp'),
                'expectedDirectives' => implode("\n", $this->getExpectedBingbotSlurpDirectives())
            ],
        ];
    }

    protected function createDefaultFile(): void
    {
        $defaultAgentRecord = new Record();
        $defaultAgentRecord->getUserAgentDirectiveList()->add(new UserAgentDirective('*'));
        $defaultAgentRecord->getDirectiveList()->add(new Directive(
            self::FIELD_ALLOW,
            self::VALUE_ALL_AGENTS_0
        ));
        $defaultAgentRecord->getDirectiveList()->add(new Directive(
            self::FIELD_DISALLOW,
            self::VALUE_ALL_AGENTS_1
        ));

        $googlebotRecord = new Record();
        $googlebotRecord->getUserAgentDirectiveList()->add(new UserAgentDirective('googlebot'));
        $googlebotRecord->getDirectiveList()->add(new Directive(
            self::FIELD_ALLOW,
            self::VALUE_GOOGLEBOT_0
        ));
        $googlebotRecord->getDirectiveList()->add(new Directive(
            self::FIELD_DISALLOW,
            self::VALUE_GOOGLEBOT_1
        ));

        $googlebotNewsRecord = new Record();
        $googlebotNewsRecord->getUserAgentDirectiveList()->add(new UserAgentDirective('googlebot-news'));
        $googlebotNewsRecord->getDirectiveList()->add(new Directive(
            self::FIELD_ALLOW,
            self::VALUE_GOOGLEBOT_NEWS_0
        ));
        $googlebotNewsRecord->getDirectiveList()->add(new Directive(
            self::FIELD_DISALLOW,
            self::VALUE_GOOGLEBOT_NEWS_1
        ));

        $bingbotAndSlurpRecord = new Record();
        $bingbotAndSlurpRecord->getUserAgentDirectiveList()->add(new UserAgentDirective('bingbot'));
        $bingbotAndSlurpRecord->getUserAgentDirectiveList()->add(new UserAgentDirective('slurp'));
        $bingbotAndSlurpRecord->getDirectiveList()->add(new Directive(
            self::FIELD_ALLOW,
            self::VALUE_BINGBOT_SLURP_0
        ));
        $bingbotAndSlurpRecord->getDirectiveList()->add(new Directive(
            self::FIELD_DISALLOW,
            self::VALUE_BINGBOT_SLURP_1
        ));

        $this->file->addRecord($defaultAgentRecord);
        $this->file->addRecord($googlebotRecord);
        $this->file->addRecord($googlebotNewsRecord);
        $this->file->addRecord($bingbotAndSlurpRecord);
    }

    /**
     * @return string[]
     */
    private function getExpectedAllAgentsDirectives(): array
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_ALL_AGENTS_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_ALL_AGENTS_1;

        return $expectedDirectives;
    }

    /**
     * @return string[]
     */
    private function getExpectedGooglebotDirectives(): array
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_GOOGLEBOT_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_GOOGLEBOT_1;

        return $expectedDirectives;
    }

    /**
     * @return string[]
     */
    private function getExpectedGooglebotNewsDirectives(): array
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_GOOGLEBOT_NEWS_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_GOOGLEBOT_NEWS_1;

        return $expectedDirectives;
    }

    /**
     * @return string[]
     */
    private function getExpectedBingbotSlurpDirectives(): array
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_BINGBOT_SLURP_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_BINGBOT_SLURP_1;

        return $expectedDirectives;
    }

    private function getUserAgentStringFixture(string $fixtureIdentifier): string
    {
        if (empty($this->userAgentStringFixtures)) {
            $path = __DIR__ . '/../fixtures/user-agent-strings.json';
            $this->userAgentStringFixtures = json_decode((string) file_get_contents($path), true);
        }

        return $this->userAgentStringFixtures[$fixtureIdentifier];
    }
}
