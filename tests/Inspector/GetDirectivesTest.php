<?php

namespace webignition\RobotsTxt\Tests\File;

use webignition\RobotsTxt\Directive\Directive;
use webignition\RobotsTxt\File\File;
use webignition\RobotsTxt\Inspector\Inspector;
use webignition\RobotsTxt\Record\Record;
use webignition\RobotsTxt\Directive\UserAgentDirective;

class GetDirectivesTest extends \PHPUnit\Framework\TestCase
{
    const FIELD_ALLOW = 'allow';
    const FIELD_DISALLOW = 'disallow';

    const VALUE_ALL_AGENTS_0 = '/allowed-path-for-*';
    const VALUE_ALL_AGENTS_1 = '/disallowed-path-for-*';
    const VALUE_GOOGLEBOT_0 = '/allowed-path-for-googlebot';
    const VALUE_GOOGLEBOT_1 = '/disallowed-path-for-googlebot';
    const VALUE_GOOGLEBOT_NEWS_0 = '/allowed-path-for-googlebot-news';
    const VALUE_GOOGLEBOT_NEWS_1 = '/disallowed-path-for-googlebot-news';
    const VALUE_BINGBOT_SLURP_0 = '/allowed-path-for-bingbot-slurp';
    const VALUE_BINGBOT_SLURP_1 = '/disallowed-path-for-bingbot-slurp';

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
     *
     * @param $userAgentString
     * @param $expectedDirectives
     */
    public function testGetDirectivesForDefaultFile($userAgentString, $expectedDirectives)
    {
        $this->createDefaultFile();
        $inspector = new Inspector($this->file);
        $inspector->setUserAgent($userAgentString);

        $this->assertEquals(
            $expectedDirectives,
            (string) $inspector->getDirectives()
        );
    }

    /**
     * @return array
     */
    public function getDirectivesForDefaultFileDataProvider()
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

    protected function createDefaultFile()
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
    private function getExpectedAllAgentsDirectives()
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_ALL_AGENTS_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_ALL_AGENTS_1;

        return $expectedDirectives;
    }

    /**
     * @return string[]
     */
    private function getExpectedGooglebotDirectives()
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_GOOGLEBOT_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_GOOGLEBOT_1;

        return $expectedDirectives;
    }

    /**
     * @return string[]
     */
    private function getExpectedGooglebotNewsDirectives()
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_GOOGLEBOT_NEWS_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_GOOGLEBOT_NEWS_1;

        return $expectedDirectives;
    }

    /**
     * @return string[]
     */
    private function getExpectedBingbotSlurpDirectives()
    {
        $expectedDirectives = [];

        $expectedDirectives[] = self::FIELD_ALLOW . ':' . self::VALUE_BINGBOT_SLURP_0;
        $expectedDirectives[] = self::FIELD_DISALLOW . ':' . self::VALUE_BINGBOT_SLURP_1;

        return $expectedDirectives;
    }

    /**
     * @param string $fixtureIdentifier
     *
     * @return string
     */
    private function getUserAgentStringFixture($fixtureIdentifier)
    {
        if (empty($this->userAgentStringFixtures)) {
            $path = __DIR__ . '/../fixtures/user-agent-strings.json';
            $this->userAgentStringFixtures = json_decode(file_get_contents($path), true);
        }

        return $this->userAgentStringFixtures[$fixtureIdentifier];
    }
}
